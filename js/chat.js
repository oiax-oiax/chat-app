document.addEventListener("DOMContentLoaded", function () {
  let currentQuestionKey = "start";

  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("option")) {
      const selectedOption = event.target.textContent;

      fetch("questions.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `action=answer&answer=${encodeURIComponent(
          selectedOption
        )}&current_question=${encodeURIComponent(currentQuestionKey)}`,
      })
        .then((response) => {
          if (!response.ok) {
            throw new Error("Network response was not ok");
          }
          return response.json();
        })
        .then((data) => {
          currentQuestionKey = data.key;
          document.getElementById("current-question").innerHTML = data.question
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\n/g, "<br>");

          let optionsHtml = "";
          for (let option in data.options) {
            if (data.options.hasOwnProperty(option)) {
              optionsHtml += `<button class="option" data-key="${data.options[option]}">${option}</button>`;
            }
          }
          document.getElementById("options-container").innerHTML = optionsHtml;

          const historyEntry = document.createElement("p");
          historyEntry.innerHTML = `<p style="margin: 20px 0;">${data.lastQuestion}<br><br> <strong>${data.lastAnswer}</strong></p>`;
          document.getElementById("chat-history").appendChild(historyEntry);

          setTimeout(() => {
            const questionContainer =
              document.getElementById("question-container");
            const chatArea = document.querySelector(".chat-wrapper");
            const rect = questionContainer.getBoundingClientRect();
            const chatAreaRect = chatArea.getBoundingClientRect();
            const scrollTop = chatArea.scrollTop;

            const targetScrollPosition =
              scrollTop +
              (rect.top - chatAreaRect.top) -
              chatArea.clientHeight / 2 +
              rect.height / 2;

            chatArea.scrollTo({
              top: targetScrollPosition,
              behavior: "smooth",
            });
          }, 100);
        })
        .catch((error) => {
          console.error(
            "There has been a problem with your fetch operation:",
            error
          );
        });
    }
  });
});

const chatButton = document.querySelector(".chat-button");
const chatArea = document.querySelector(".chat-area");
chatButton.addEventListener("click", () => {
  chatButton.classList.add("active");
  chatArea.classList.add("active");
});

const chatQuit = document.querySelector(".chat-quit");
chatQuit.addEventListener("click", () => {
  chatButton.classList.remove("active");
  chatArea.classList.remove("active");
});
