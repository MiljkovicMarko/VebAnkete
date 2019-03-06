function validateSurveyForm()
{
    let status=true;
    let e=document.querySelector("#survey-error-message");
    e.classList.add("d-none");
    e.innerHTML="";
    const title= document.querySelector("#title").value;
    if(!title.match(/.*[^\s]{3,}.*/))
    {
        e.innerHTML+="Naslov mora da sadrži bar tri vidljiva karaktera!"
        e.classList.remove('d-none')
        status= false;
    }
    return status;
}
let btnChoiceClicked = false;
function btnChoiceClick()
{
    btnChoiceClicked=true;
}
function validateQuestionForm()
{
    let status=true;
    let e=document.querySelector("#question-error-message");
    e.classList.add("d-none");
    e.innerHTML="";
    let question= document.querySelector("#question");
    if(!question.value.match(/.*[^\s]{3,}.*/))
    {
        e.innerHTML+="Pitanje mora da sadrži bar tri vidljiva karaktera!<br>"
        e.classList.remove('d-none')
        question.focus();
        status = false;
    }
    let choices= document.querySelector("#choices").value;
    if(btnChoiceClicked && !choices.match(/.*[^\s]{1,}.*/))
    {
        e.innerHTML+="Ponudjeni odgovori moraju da sadrže bar jedan vidljiv karakter!<br>"
        e.classList.remove('d-none')
        question.focus();
        status = false;
    }
    btnChoiceClicked=false;
    return status;
}
