function form(event){
    event.preventDefault();
    var question = document.querySelector("#form input[type='text']").value;
    var reponse = document.querySelector("#reponse");
    var questions = new Array(
        "hi",
        "how are you",
        "where are we",
        "what are you doing",
        "what is going on",
        "why are we doing this",
        "how is the weather",
        "who are you",
        "what is your level",
        "you good?",
        "hello",
        "ça va?",
        "bye"
    );
    var answers = new Array(
        "hello!",
        "I`am fine.",
        "at 42!",
        "piscine PHP!",
        "I have no idea!",
        "Don know bro!",
        "super cool!",
        "a chat robot",
        "LEVEL 999999999.99!!!!!!!",
        "Yeah!",
        "Helllllooooo!!!",
        "ça va bien!!!!!",
        "BYE BYE, see you soon!"
    );
    var index = questions.indexOf(question);
    if (index > -1)
    {
        reponse.innerHTML = answers[index];
    }
    else
        reponse.innerHTML = "I don`t understand, sorry."
    document.querySelector("#form input[type='text']").value = "";
}

window.onload = function () {
    document.querySelector("#form").addEventListener("submit", form);
}