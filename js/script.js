var keyword=document.getElementById('keyword');
var tombolCari=document.getElementById('tombol-cari');
var container=document.getElementById('container');

keyword.addEventListener('keyup',function() {
    var xhr=new XMLHttpRequest();

        xhr.onreadystatechange=function(){
            if (this.readyState == 4 && this.status == 200) {
                container.innerHTML = xhr.responseText;
            }
        };
        xhr.open('GET','ajax/ajaxMhs2.php?keyword='+keyword.value, true);
        xhr.send();
});