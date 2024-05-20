class Ajax {
    constructor(baseURL) {
        this.baseURL = baseURL;
    }

    request(method, url, data = null) {
        return fetch(this.baseURL + url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: data ? JSON.stringify(data) : null
        })
        .then(response => response.json())
        .catch(error => console.error('Error:', error));
    }

    get(url) {
        return this.request('GET', url);
    }

    post(url, data) {
        return this.request('POST', url, data);
    }

    put(url, data) {
        return this.request('PUT', url, data);
    }

    delete(url, data) {
        return this.request('DELETE', url, data);
    }
}

// Usage example

