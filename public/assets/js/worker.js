async function decryptData(encryptedData, key) { 
    let encryptedBinary = atob(encryptedData); 
    let iv = encryptedBinary.slice(0, 16);
    let encryptedText = encryptedBinary.slice(16); 
    let keyBuffer = new TextEncoder().encode(key);
    let keyArray = await crypto.subtle.importKey('raw', keyBuffer, { name: 'AES-CBC' }, false); 
    let ivBuffer = new TextEncoder().encode(iv);
    let encryptedDataBuffer = new Uint8Array(Array.prototype.map.call(encryptedText, function(c) { return c.charCodeAt(0); }));
    let decryptedData = await crypto.subtle.decrypt({ name: 'AES-CBC', iv: ivBuffer }, keyArray, encryptedDataBuffer);
    let decryptedText = new TextDecoder().decode(decryptedData);
    return decryptedText;
}  
async function parsePage(data,url){
    var page = '';
    console.log(data)
    for (let p = 0; p < data.data.length; p++) { 
        const response = await fetch(`${url}?page=${data.page}&part=${p}`);
        const part = await response.json();
        page += await decryptData(part.data,part.hash);
    }
    const encoder = new TextEncoder();
    const uint8Array = encoder.encode(page);
    postMessage({ 
        action: 'page', 
        data: {
            index:index,
            render: uint8Array
        }
    });
}
onmessage=function(e){
    const { action, data } = e.data 
    if (action === 'render') { 
        var pdf = data;
        for (let index = 0; index < pdf.data.length; index++) {
            const element = pdf.data[index];
            parsePage(element,pdf.url)
        }
    }
};
