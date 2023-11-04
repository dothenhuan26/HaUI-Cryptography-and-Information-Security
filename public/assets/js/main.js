let message = document.querySelector('.message').value;
let ciphertext = document.querySelector('.ciphertext').value;
let move = document.querySelector('.move');
let plaintext = document.querySelector('.plaintext');
let signature = document.querySelector('.signature');
let check = document.querySelector('.check');
let hidden = document.querySelector('.hidden').value;
let notify = document.querySelector('.notify');
const inputFile = document.getElementById('file');

move.onclick = function () {
    plaintext.value = message;
    signature.value = ciphertext;
}

inputFile.addEventListener('change', function () {
    const file = this.files[0];
    const fileType = file.type;
    if (fileType === 'text/plain') {
        // File là định dạng txt
        console.log("day la text");
    } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || fileType === 'application/msword') {
        console.log('word');
    } else {
        console.log('file');
    }
});

check.onclick = function () {
    plaintext = document.querySelector('.plaintext').value;
    signature = document.querySelector('.signature').value;
    md5hidden = document.querySelector('.md5hidden').value;

    if (md5hidden == hidden && plaintext == message && signature == ciphertext) {
        notify.value = "Chữ ký đúng";
    } else {
        notify.value = "Chữ ký sai";
    }
}

function isDocx(file) {
    return file.type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
}

function isDoc(file) {
    return file.type === "application/msword";
}

document.getElementById("file").addEventListener("change", function (e) {
    var file = e.target.files[0];
    if (isDocx(file) || isDoc(file)) {
        mammoth.convertToHtml({arrayBuffer: file.arrayBuffer()})
            .then(function (result) {
                document.querySelector(".message").outerHTML = '<div style="flex: 2;">' + result.value + '</div>';
            })
            .done();
    } else {
        var reader = new FileReader();
        reader.onload = function () {
            document.querySelector(".message").value = reader.result;
        }
        reader.onerror = function () {
            console.log(reader.error);
        }
        reader.readAsText(this.files[0]);
    }
});

document.getElementById("fileraw").addEventListener("change", function (e) {
    var file = e.target.files[0];
    if (isDocx(file) || isDoc(file)) {
        mammoth.convertToHtml({arrayBuffer: file.arrayBuffer()})
            .then(function (result) {
                document.querySelector(".plaintext").outerHTML = '<div style="flex: 2;">' + result.value + '</div>';
            })
            .done();
    } else {
        var reader = new FileReader();
        reader.onload = function () {
            document.querySelector(".plaintext").value = reader.result;
        }
        reader.onerror = function () {
            console.log(reader.error);
        }
        reader.readAsText(this.files[0]);
    }
});

document.getElementById("filesign").addEventListener("change", function () {
    var reader = new FileReader();
    reader.onload = function () {
        document.querySelector(".signature").value = reader.result;
    }
    reader.onerror = function () {
        console.log(reader.error);
    }
    reader.readAsText(this.files[0]);
});







