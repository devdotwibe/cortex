decryptData=async function(encryptedData, key) { 
    let encryptedBinary = atob(encryptedData); 
    let iv = encryptedBinary.slice(0, 16);
    let encryptedText = encryptedBinary.slice(16); 
    let keyBuffer = new TextEncoder().encode(key);
    let keyArray = await crypto.subtle.importKey('raw', keyBuffer, { name: 'AES-CBC',length: 256 }, false,['encrypt', 'decrypt']); 
    let ivBuffer = new Uint8Array(Array.prototype.map.call(iv, function(c) { return c.charCodeAt(0); }));
    let encryptedDataBuffer = new Uint8Array(Array.prototype.map.call(encryptedText, function(c) { return c.charCodeAt(0); }));
    let decryptedData = await crypto.subtle.decrypt({ name: 'AES-CBC', iv: ivBuffer }, keyArray, encryptedDataBuffer);
    console.log('s')
    let decryptedText = new TextDecoder().decode(decryptedData);
    return decryptedText;
};
parsePage=async function(index,data,url){
    var page ='';
    for (let p = 0; p < data.data.length; p++) { 
        const response = await fetch(`${url}?page=${index}&part=${p}`,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json', 
                'X-Requested-With': 'XMLHttpRequest'
            },
        });
        const part = await response.json();
        await decryptData(part.data,part.hash);
        // const body = await decryptData(part.data,part.hash);
        // page +=
    }
    this.postMessage({ 
        action: 'page', 
        data: {
            index:index,
            render: page
        }
    });
};
onmessage=function(e){
    const { action, data } = e.data 
    if (action === 'render') { 
        var pdf = data;
        for (let index = 0; index < pdf.data.length; index++) {
            const element = pdf.data[index];
            parsePage(index,element,pdf.url)
        }
    }
};
