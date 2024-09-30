self.initExam=async (data)=>{  
    const response = await fetch(data.url, { method:data.method, headers:data.headers }); 
    if(response.ok){
        const responseData = await response.json();
        self.postMessage({ action: 'progress', data: responseData });
        if(responseData.next_page_url){
            self.initExam({
                ...data,
                url:responseData.next_page_url,
            })
        }else{
            self.postMessage({ action: 'examStart', data: responseData });
        }
    }else{
        self.postMessage({ action: 'error', data: response.statusText });
    }
};
self.onmessage = function(e) {
    const { action, data } = e.data; 
    if (typeof self[action] === 'function') {
        self[action](data);
    } else {
        self.postMessage({ action: 'error', data: 'Invalid action' });
    } 
};