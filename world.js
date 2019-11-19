document.addEventListener("DOMContentLoaded", ()=>{
    document.getElementById("lookup").addEventListener("click",buttonAction);
    
});
    
var httpRequest;
function buttonAction(event){
       event.preventDefault();
       httpRequest = new XMLHttpRequest();
       var countryVal=document.getElementById("country").value;
       //var url ="world.php?country="+ countryVal;
       httpRequest.onreadystatechange = fetchData;
       httpRequest.open('GET',"world.php?country="+ countryVal,true);
       httpRequest.send();
}
    
function fetchData(){
    if (httpRequest.readyState === XMLHttpRequest.DONE) {
        console.log("hello");
        if (httpRequest.status === 200) {
            document.getElementById('result').innerHTML= httpRequest.responseText;
   }else {
     alert('There was a problem with the request.');
}}};

