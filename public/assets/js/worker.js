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