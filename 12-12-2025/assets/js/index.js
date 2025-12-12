    console.log(2+1)
    alert(1);
    console.log(location.href);
    let text=document.getElementById('text');
    text.style.color='red';

    let box = document.querySelector("#box");
    box.style.background="yellow";


    let allMsg = document.querySelectorAll(".msg");
    allMsg.forEach(m => {
    m.style.fontSize = "40px";
    });

    let div=document.getElementsByTagName('div');
    console.log("div length: "+ div.length);

    console.log(document.body.className);

    alert("width:"+ window.innerWidth);

    document.body.style.background = "green";
    setTimeout(() => document.body.style.background = "", 1000);
        
    document.getElementById("box").innerHTML = "<b>Hello World</b>";


    let p = document.createElement("p");
    p.innerHTML = "This is a new paragraph"; 
    document.getElementById("box-2").appendChild(p);

    document.getElementById("btn").addEventListener("click", function() {
    alert("Button clicked!");
    });

    confirm("are your sure?");