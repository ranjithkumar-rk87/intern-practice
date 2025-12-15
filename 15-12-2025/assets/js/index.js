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