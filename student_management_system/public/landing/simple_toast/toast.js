const transitionLength = 700;

let toastContain = document.createElement('div');
toastContain.classList.add('toastContain');
document.body.appendChild(toastContain);
var time = 4000;
function toast(str, addClass = 'default', time) {
    if (!time || time === 'default') {
        time = 4000;
    }
    let toastEl = document.createElement('div');
    toastEl.classList.add('toast', addClass);
    toastEl.innerText = str;
    toastContain.prepend(toastEl);
    setTimeout(() => toastEl.classList.add('open'));
    setTimeout(
        () => toastEl.classList.remove('open'),
        time
    );
    setTimeout(
        () => toastContain.removeChild(toastEl),
        time + transitionLength
    );
}
function toastError(str){
    toast(str, addClass = 'critical');
}
function toastScucess(str){
    toast(str, addClass = 'success');
}

let uploading_div = document.createElement('div');
uploading_div.classList.add('toastContain');
document.body.appendChild(uploading_div);
let uploadToastEl = document.createElement('div');
toastr = {
    uploading: function(){
        uploadToastEl.classList.add('toast', 'info');
        uploadToastEl.innerText = 'Uploading...';
        uploading_div.prepend(uploadToastEl);
        uploadToastEl.classList.add('open');
    },
    uploaded: function(){
        uploadToastEl.classList.remove('open');
        uploading_div.removeChild(uploadToastEl);
    }
};