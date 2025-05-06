// Log to check the flag before the script runs
console.log('Before setting:', window.chatbotScriptInitialized);

if (!window.chatbotScriptInitialized) { 
    // Log to confirm the script is being executed only once
    console.log('Initializing chatbot script...');

    // Set the flag to true
    window.chatbotScriptInitialized = true;

    const chatbotToggler = document.querySelector(".chatbot-toggler");
    const closeBtn = document.querySelector(".close-btn");
    const chatbox = document.querySelector(".chatbox");
    const chatbot = document.querySelector('.chatbot');
    const chatInput = document.querySelector(".chat-input textarea");
    const sendChatBtn = document.querySelector(".chat-input span");
    const inputInitHeight = chatInput.scrollHeight;

    const createChatLi = (message, className) => {
        const chatLi = document.createElement("li");
        chatLi.classList.add("chat", `${className}`);
        let chatContent = className === "outgoing" ? `<p></p>` : `  <span><img src="https://img.icons8.com/?size=256&id=37410&format=png" alt=""></span><p></p>`;
        chatLi.innerHTML = chatContent;
        chatLi.querySelector("p").textContent = message;
        return chatLi;
    };

    const generateResponse = async (chatElement) => {
        const outgoingMessages = document.querySelectorAll(".outgoing p");
        const messageElement = chatElement.querySelector("p");
        const latestOutgoingMessage = outgoingMessages[outgoingMessages.length - 1]?.textContent;
        const API_URL = `https://nodejs-chat-fi0c.onrender.com/gemini/${encodeURIComponent(latestOutgoingMessage)}`;

        fetch(API_URL, {
            method: 'POST',
        })
        .then(res => res.json()).then(data => {
            messageElement.textContent = data.trim();
        }).catch(() => {
            messageElement.classList.add("error");
            messageElement.textContent = "Oops! Something went wrong. Please try again.";
        }).finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
    };

    const handleChat = () => {
        userMessage = chatInput.value.trim();
        if (!userMessage) return;

        chatInput.value = "";
        chatInput.style.height = `${inputInitHeight}px`;

        chatbox.appendChild(createChatLi(userMessage, "outgoing"));
        chatbox.scrollTo(0, chatbox.scrollHeight);

        setTimeout(() => {
            const incomingChatLi = createChatLi("generating responses...", "incoming");
            chatbox.appendChild(incomingChatLi);
            chatbox.scrollTo(0, chatbox.scrollHeight);
            generateResponse(incomingChatLi);
        }, 600);
    };

    chatInput.addEventListener("input", () => {
        chatInput.style.height = `${inputInitHeight}px`;
        chatInput.style.height = `${chatInput.scrollHeight}px`;
    });

    chatInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
            e.preventDefault();
            handleChat();
        }
    });

    function hideChatbot() {
        // Close chatbot logic (optional)
    }

    function handleClick(event) {
        if (chatbot.contains(event.target)) {
            console.log("Click inside the chatbot.");
        } else {
            document.body.classList.remove("show-chatbot");
        }
    }

    document.addEventListener('click', handleClick);

    chatbotToggler.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent this click from propagating to the document listener
        document.body.classList.toggle("show-chatbot");
    });



    sendChatBtn.addEventListener("click", handleChat);
    closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));

}
else {
    const chatbotToggler = document.querySelector(".chatbot-toggler");
    const closeBtn = document.querySelector(".close-btn");
    const chatbox = document.querySelector(".chatbox");
    const chatbot = document.querySelector('.chatbot');
    const chatInput = document.querySelector(".chat-input textarea");
    const sendChatBtn = document.querySelector(".chat-input span");
    const inputInitHeight = chatInput.scrollHeight;

    const createChatLi = (message, className) => {
        const chatLi = document.createElement("li");
        chatLi.classList.add("chat", `${className}`);
        let chatContent = className === "outgoing" ? `<p></p>` : `  <span><img src="https://img.icons8.com/?size=256&id=37410&format=pn" alt=""></span><p></p>`;
        chatLi.innerHTML = chatContent;g
        chatLi.querySelector("p").textContent = message;
        return chatLi;
    };

    const generateResponse = async (chatElement) => {
        const outgoingMessages = document.querySelectorAll(".outgoing p");
        const messageElement = chatElement.querySelector("p");
        const latestOutgoingMessage = outgoingMessages[outgoingMessages.length - 1]?.textContent;
        const API_URL = `https://nodejs.onrender.com/gemini/${encodeURIComponent(latestOutgoingMessage)}`;

        fetch(API_URL, {
            method: 'POST',
        })
        .then(res => res.json()).then(data => {
            messageElement.textContent = data.trim();
        }).catch(() => {
            messageElement.classList.add("error");
            messageElement.textContent = "Oops! Something went wrong. Please try again.";
        }).finally(() => chatbox.scrollTo(0, chatbox.scrollHeight));
    };

    const handleChat = () => {
        userMessage = chatInput.value.trim();
        if (!userMessage) return;

        chatInput.value = "";
        chatInput.style.height = `${inputInitHeight}px`;

        chatbox.appendChild(createChatLi(userMessage, "outgoing"));
        chatbox.scrollTo(0, chatbox.scrollHeight);

        setTimeout(() => {
            const incomingChatLi = createChatLi("generating responses...", "incoming");
            chatbox.appendChild(incomingChatLi);
            chatbox.scrollTo(0, chatbox.scrollHeight);
            generateResponse(incomingChatLi);
        }, 600);
    };

    chatInput.addEventListener("input", () => {
        chatInput.style.height = `${inputInitHeight}px`;
        chatInput.style.height = `${chatInput.scrollHeight}px`;
    });

    chatInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
            e.preventDefault();
            handleChat();
        }
    });

    function hideChatbot() {
        // Close chatbot logic (optional)
    }

    function handleClick(event) {
        if (chatbot.contains(event.target)) {
            if (document.body.classList.contains("show-chatbot")) {
                // The class "show-chatbot" exists, so remove it
                // document.body.classList.remove("show-chatbot");
                console.log('show-chatbot class removed');
            } else {
                document.body.classList.toggle("show-chatbot");
                // The class does not exist, so you can handle this case if needed
                console.log('show-chatbot class does not exist');
            }
        } else {

            // document.body.classList.remove("show-chatbot");
        }
    }

    document.addEventListener('click', handleClick);

    chatbotToggler.addEventListener("click", (event) => {
        event.stopPropagation(); // Prevent this click from propagating to the document listener
        document.body.classList.toggle("show-chatbot");
    });



    sendChatBtn.addEventListener("click", handleChat);
    closeBtn.addEventListener("click", () => document.body.classList.remove("show-chatbot"));

}
