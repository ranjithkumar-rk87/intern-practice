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

    console.log(2+2+'1');
    console.log('1'+2+2);

    console.log("Absolute value is: " + Math.abs(-10));
    console.log("Rounded value is: " + Math.round(4.5));
    console.log("Floor value of is: " + Math.floor(4.5));
    console.log("Ceil value is: " + Math.ceil(4.2));
    console.log("pow is: " + Math.pow(2, 3));
    console.log("Minimum is: " + Math.min(1, 3, 4));
    console.log("Maximum  is: " + Math.max(10, 1, 2));
    console.log("random is"+ Math.random())
    console.log("remove deciaml is "+Math.trunc(4.9));
    console.log("PI is ",Math.PI);
    console.log("log is"+Math.log(10));


    let str = "Hello";
    console.log("string length ",str.length);
    console.log("uppercase ",str.toUpperCase());
    console.log("lowercase ",str.toLowerCase());
    let str1 = "   Hello   ";
    console.log(str1.trim());

    let str2 = "Hello World";
    console.log(str2.replace("World", "JS"));

    let str3 = "JavaScript";

    console.log("include ",str3.includes("Script"));
    console.log("startwith ",str3.startsWith("Java"));
    console.log("endwith ",str3.endsWith("Script"));
    console.log("charAt is "+str3.charAt(1));
    console.log("index of "+str3.indexOf("Java"));
    console.log("last index: "+str3.lastIndexOf("c"));
    console.log("slice is "+str3.slice(0, 5));
    
    let text = "HTML,CSS,JS";
    console.log(text.split(","));

    let a = "Hello";
    let b = "World";

    console.log(a.concat(" ", b));
    console.log("Hi ".repeat(3));
    console.log("5".padStart(3, "0"));
    console.log("5".padEnd(3, "0"));

    let s = "I love JS and JS";

    console.log(s.match(/JS/g));
    console.log(s.search("love"));
    console.log((100).toString());


    let arr = [10, 20, 30, 40];
    console.log(arr[0]);
    console.log(arr[2]);

    console.log("array index ",arr[arr.length - 1]);
    console.log(arr.at(-1));

    console.log("array length "+arr.length);
    console.log("Push",arr.push(50));
    console.log("unshift",arr.unshift(5));

    console.log("pop ",arr.pop());
    console.log("shift ",arr.shift());
    
    let newArr = arr.slice(1, 3);
    console.log("new array ",newArr);

    let p = [1, 2];
    let q = [3, 4];

    let c = p.concat(q);
    console.log("array",c);
    
    console.log("include ",arr.includes(20));
    console.log("index of ",arr.indexOf(30));
    
    let nums = [10, 20, 30, 40];

    console.log("find ",nums.find(n => n > 25));
    console.log("filter ",nums.filter(n => n > 25)); 

    let doubled = nums.map(n => n * 2);
    console.log("map",doubled);

    nums.reverse();
    console.log(nums);

    console.log(Array.isArray(nums));
    

    let person = {
      name: "Ranjith",
      age: 25,
      city: "Rajapalayam"
    };

    console.log(person.name);
    console.log(person["age"]);
    person.country = "India";
    person.age = 26;
    console.log(Object.keys(person));
    console.log(Object.values(person));
    console.log(Object.entries(person));
    let student = {
      name: "Ranjith",
      marks: {
        math: 90,
        english: 85
      }
    };

    console.log("math mark",student.marks.math);

    console.log("name" in person);


    let jsonData = JSON.stringify(person);
    console.log(jsonData);
    console.log(typeof jsonData);
    console.log(typeof person);

    let jsonData1 = '{"name":"Ranjith","age":25}';
    let obj = JSON.parse(jsonData1);

    console.log(obj.name);
    console.log(typeof obj);

    let data = `{
      "name": "Ranjith",
      "marks": {"math": 90, "english": 85}
    }`;

    let obj1 = JSON.parse(data);
    console.log(obj1.marks.math);

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

    let nums1 = [7, 8, 9];

    nums1.forEach(function (n) {
      console.log(n);
    });

    for (let n of nums1) {
      console.log(n);
    }

    console.log(nums1.toString());
    console.log(nums1.join(" | "));



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

    const sayHello = () => console.log("Hello");
    sayHello();


    try {
      let x = y + 10; 
      console.log(x);
    } catch (err) {
      console.log("Error:", err.message);
    }finally {
      console.log("Finally block");
    }


    setTimeout(function() {
      console.log("Hello after 2 seconds");
    }, 2000);

    function greet(name, callback) {
      console.log("Hello " + name);
      callback();
    }

    function sayBye() {
      console.log("Goodbye!");
    }

    greet("test", sayBye);

    async function getUsers() {
      let res = await fetch("https://jsonplaceholder.typicode.com/users");
      let data = await res.json();
      console.log(data);
    }

    getUsers();

    fetch("https://jsonplaceholder.typicode.com/posts", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        title: "My Post",
        body: "This is dummy data",
        userId: 1
      })
    })
    .then(res => res.json())
    .then(data => console.log(data));


    fetch("https://jsonplaceholder.typicode.com/posts/1", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        id: 1,
        title: "Updated Title",
        body: "Updated content",
        userId: 1
      })
    })
    .then(res => res.json())
    .then(data => console.log(data));




    fetch("https://jsonplaceholder.typicode.com/posts/1", {
      method: "DELETE"
    })
    .then(res => {
      if (res.ok) {
        console.log("Deleted successfully");
      }
    });


    function addTask() {
        let input = document.getElementById("taskinput");
        let taskText = input.value;

        if (taskText === "") {
          alert("Enter a task");
          return;
        }

        let li = document.createElement("li");
        li.innerText = taskText;

        let deleteBtn = document.createElement("button");
        deleteBtn.innerText = "Delete";

        deleteBtn.onclick = function () {
          li.remove();
        };

        li.appendChild(deleteBtn);

        document.getElementById("tasklist").appendChild(li);

        input.value = "";
    }


