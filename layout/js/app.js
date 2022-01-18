let icon = document.querySelectorAll(".icon");
let pass = document.querySelectorAll(".myPass"); 
let remove = document.querySelectorAll(".remove"); 
let addBtn = document.querySelector(".addBtn"); 
let per = document.querySelector(".per"); 
if(icon.length>0){
icon[0].style.width="5px";
console.log(pass[0].getAttribute("type"));
icon[0].addEventListener("click",function(){
    if(pass[0].getAttribute("type")=="password"){
        pass[0].setAttribute("type","text");
    }
    else{
        pass[0].setAttribute("type","password");
    }});
}