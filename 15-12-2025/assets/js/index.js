    document.getElementById("btn").addEventListener("click", () => {
    alert("clicked");
    });

    document.getElementById("dblClickBtn").addEventListener("dblclick", () => {
        alert("Button double clicked");
    });

   const box = document.getElementById("box");

    box.addEventListener("mouseover", () => {
      box.style.background = "green";
      box.style.color="white";
      box.textContent = "Mouse Over";
    });

    box.addEventListener("mouseout", () => {
      box.style.background = "yellow";
      box.style.color="black";
      box.textContent = "Mouse Out";
    });

     document.getElementById("keyInput").addEventListener("keydown", (e) => {
      console.log("Key Down:", e.key);
    });

    document.getElementById("keyInput").addEventListener("keyup", (e) => {
      console.log("Key Up:", e.key);
    });

    document.getElementById("keyInput").addEventListener("input", (e) => {
      console.log("Input:", e.target.value);
    });

    document.getElementById("selectBox").addEventListener("change", (e) => {
      alert("Selected: " + e.target.value);
    });

    const mouseBox = document.getElementById("mouseBox");

    mouseBox.addEventListener("mousedown", () => console.log("Mouse Down"));
    mouseBox.addEventListener("mouseup", () => console.log("Mouse Up"));
    mouseBox.addEventListener("mousemove", () => console.log("Mouse Move"));
    mouseBox.addEventListener("mouseenter", () => mouseBox.style.background = "green");
    mouseBox.addEventListener("mouseleave", () => mouseBox.style.background = "skyblue");
    
    const focusInput = document.getElementById("focusInput");
    focusInput.addEventListener("focus", () => console.log("Input Focus"));
    focusInput.addEventListener("blur", () => console.log("Input Blur"));

    const clipInput = document.getElementById("clipInput");

    clipInput.addEventListener("copy", () => console.log("Copied"));
    clipInput.addEventListener("cut", () => console.log("Cut"));
    clipInput.addEventListener("paste", () => console.log("Pasted"));

    const dragBox = document.getElementById("dragBox");
    const dropBox = document.getElementById("dropBox");

    dragBox.addEventListener("dragstart", () => console.log("Drag Start"));
    dragBox.addEventListener("dragend", () => console.log("Drag End"));

    dropBox.addEventListener("dragover", (e) => e.preventDefault());
    dropBox.addEventListener("drop", () => {
    dropBox.textContent = "Dropped!";
    console.log("Dropped");
    });

    const video = document.getElementById("video");

    video.addEventListener("play", () => console.log("Video Play"));
    video.addEventListener("pause", () => console.log("Video Pause"));
    video.addEventListener("ended", () => console.log("Video Ended"));
    video.addEventListener("volumechange", () => console.log("Volume Change"));

     window.addEventListener("resize", () => {
      console.log("Window Resized");
    });

    window.addEventListener("scroll", () => {
      console.log("Page Scrolling");
    });


    let message="Hello";
    alert(message);

    let name='Ranjith'
    console.log(`Hello ${name}`);
    console.log(`result is ${2+2}`);

    let isGreater=4 >3;
    console.log(isGreater);

    let age;
    console.log(age);

    console.log(typeof 10);
    
    age=prompt("how old are you?",20);
    console.log("your age is ",age)

    let human=confirm("are you human?");
    console.log(human);

    let number=2;
    console.log(typeof number);
    number=String(number);
    console.log(typeof number);


    let x=10, y=2;
    console.log("x-y",x-y);
    console.log("exponentiation",2 ** 3);

    let counter=0;
    console.log(counter++);
    console.log(++counter);

    let voter_age = 18;

    if (voter_age >= 18) {
    console.log("You are eligible to vote");
    }else {
    console.log("Not eligible");
    }

    let mark = 75;

    if (mark >= 90) {
    console.log("Grade A");
    } else if (mark >= 75) {
    console.log("Grade B");
    } else if (mark >= 50) {
    console.log("Grade C");
    } else {
    console.log("Fail");
    }

    let day = 3;

    switch (day) {
    case 1:
        console.log("Monday");
        break;
    case 2:
        console.log("Tuesday");
        break;
    case 3:
        console.log("Wednesday");
        break;
    default:
        console.log("Invalid day");
    }

    console.log(1 || 0);

    let user;
    console.log(user ?? "Anonymous");


    let i=0;
    while(i<3){
        console.log(i);
        i++;
    }

    let j = 0;
    do {
    console.log( j );
    j++;
    } while (j < 3);


    for (let k = 0; k < 3; k++) {
        console.log(k);
    }

    function showMessage() {
    alert( 'Hello everyone!' );
    }

showMessage();
showMessage();

    function sayHii(){
        console.log("HII");
    }
    test=sayHii;

    test();

    const add = (a, b) => a + b;

    console.log(add(5, 3));

