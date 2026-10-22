// Network Inspector for StudentHub Portal
// Features: real-time network request monitoring, AbortController debounce,
// and API response visualization in a side panel

// ============================================
// Network Request Monitor Class
// ============================================
class NetworkMonitor {
    constructor() {
        this.observers = [];
        this.debounceTimers = new Map();
        this.maxRequestLogs = 100;
        this.isMonitoring = false;
    }

    // Start monitoring fetch/XHR requests
    start() {
        if (this.isMonitoring) return;
        this.isMonitoring = true;

        // Override XHR open
        const nativeXHROpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function(method, url, ...args) {
            this._method = method;
            this._url = url;
            this._startTime = performance.now();
            return nativeXHROpen.apply(this, arguments);
        };

        // Override XHR send
        const nativeXHRSend = XMLHttpRequest.prototype.send;
        XMLHttpRequest.prototype.send = function(body) {
            this._body = body;
            this._startTime = this._startTime || performance.now();
            this.addEventListener('loadend', () => this._onLoadEnd(), { once: true });
            return nativeXHRSend.apply(this, arguments);
        };

        // Override fetch
        const nativeFetch = window.fetch;
        window.fetch = function(input, init) {
            const controller = new AbortController();
            const timeout = init && init.timeout ? init.timeout : 30000;
            setTimeout(() => controller.abort(), timeout);

            const startTime = performance.now();
            return nativeFetch(input, {
                ...init,
                signal: controller.signal
            }).then(response => {
                const duration = performance.now() - startTime;
                this._logRequest({
                    method: init?.method || 'GET',
                    url: typeof input === 'string' ? input : input.url,
                    status: response.status,
                    duration: duration.toFixed(2),
                    timestamp: new Date().toISOString()
                });
                return response;
            }.bind(this));
        }.bind(this);

        console.log('Network Monitor started');
    }

    // Log a request
    _logRequest(requestData) {
        // Debounce rapid requests
        const key = requestData.url + '|' + requestData.method;
        if (this.debounceTimers.has(key)) {
            clearTimeout(this.debounceTimers.get(key));
        }

        this.debounceTimers.set(key, setTimeout(() => {
            this.observers.forEach(observer => observer(requestData));
            this._cleanupLogs();
        }, 50));
    }

    // Subscribe to request events
    subscribe(callback) {
        this.observers.push(callback);
        return () => {
            this.observers = this.observers.filter(o => o !== callback);
        };
    }

    // Stop monitoring
    stop() {
        this.isMonitoring = false;
        XMLHttpRequest.prototype.open = nativeXHROpen;
        XMLHttpRequest.prototype.send = nativeXHRSend;
        window.fetch = nativeFetch;
        console.log('Network Monitor stopped');
    }
}

// ============================================
// Debounce Utility
// ============================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Create debounced version for search
const debouncedSearch = debounce((searchTerm) => {
    // Dispatch custom event for search
    const event = new CustomEvent('studenthub:search', {
        detail: { term: searchTerm }
    });
    document.dispatchEvent(event);
}, 300);

// ============================================
// API Response Logger
// ============================================
function logAPIResponse(responseData) {
    const logEntry = document.createElement('div');
    logEntry.className = 'network-log-entry';
    logEntry.innerHTML = `
        <div class="log-method ${responseData.method.toLowerCase()}">
            <span>${responseData.method} ${responseData.url.split('?')[0]}</span>
        </div>
        <div class="log-status status-${responseData.status < 400 ? 'success' : response.status < 500 ? 'warning' : 'error'}">
            ${responseData.status}
        </div>
        <div class="log-duration">${responseData.duration}ms</div>
        <div class="log-timestamp">${new Date(responseData.timestamp).toLocaleTimeString()}</div>
    `;
    return logEntry;
}

// ============================================
// Initialize on DOMContentLoaded
// ============================================
document.addEventListener('DOMContentLoaded', () => {
    const monitor = new NetworkMonitor();
    
    // Start monitoring after a short delay to let page initialize
    setTimeout(() => {
        monitor.start();
    }, 500);

    // Listen for debounced search events
    document.addEventListener('studenthub:search', (e) => {
        console.log('Search term:', e.detail.term);
        // Could trigger API call here
    });

    // Export for use in other modules
    window.NetworkMonitor = NetworkMonitor;
    window.debounce = debounce;
    window.debouncedSearch = debouncedSearch;
});