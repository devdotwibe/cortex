async function decryptData(encryptedData, key) { 
    let encryptedBinary = atob(encryptedData); 
    let iv = encryptedBinary.slice(0, 16);
    console.log(typeof iv ,iv)
    let encryptedText = encryptedBinary.slice(16); 
    let keyBuffer = new TextEncoder().encode(key);
    let keyArray = await crypto.subtle.importKey('raw', keyBuffer, { name: 'AES-CBC',length: 256 }, false,['encrypt', 'decrypt']); 
    let ivBuffer = new TextEncoder().encode(iv);
    let encryptedDataBuffer = new Uint8Array(Array.prototype.map.call(encryptedText, function(c) { return c.charCodeAt(0); }));
    let decryptedData = await crypto.subtle.decrypt({ name: 'AES-CBC', iv: ivBuffer }, keyArray, encryptedDataBuffer);
    let decryptedText = new TextDecoder().decode(decryptedData);
    return decryptedText;
}  
async function parsePage(index,data,url){
    var page = '';
    for (let p = 0; p < data.data.length; p++) { 
        const response = await fetch(`${url}?page=${index}&part=${p}`,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json', 
                'X-Requested-With': 'XMLHttpRequest'
            },
        });
        const part = await response.json();
        await decryptData(data.data[p],part.hash);
        console.log(part)
        page +=part.data// await decryptData(part.data,part.hash);
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
            parsePage(index,element,pdf.url)
        }
    }
};
