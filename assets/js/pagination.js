
let currentPage=1;
let maxPerPage=18;
let lenSurveys;
let pgPrev,pgNext,pg1,pg2,pg3,pgLnk1,pgLnk2,pgLnk3;
loadSurveys();
loadPagination();

function prevClicked(){
    if(currentPage>1)
    {
        currentPage--;
        loadSurveys();
        loadPagination();
    }
    return false;
}
function nextClicked(){
    if(currentPage*maxPerPage<lenSurveys)
    {
        currentPage++;
        loadSurveys();
        loadPagination();
    }
    return false;
}
function pg1Clicked(){
    return prevClicked();
}
// function pg2Clicked(){
//     return false;
// }
function pg3Clicked(){
    return nextClicked();
}

function loadSurveys() {
    let e = document.querySelector("#surveys");
    let allSurveys = JSON.parse(e.dataset.surveys);
    lenSurveys=allSurveys.length;
    let surveys= allSurveys.slice((currentPage-1)*maxPerPage,currentPage*maxPerPage);
    let html = "";
    for (s in surveys) {
        html += "<div class='col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 p-2'>" +
                    "<div class='card w-100 h-100'>" +
                        "<div class='card-header p-0'>" +
                            "<a class='btn btn-light w-100 h-100' href='" + encodeURI(BASE) + 'surveys/' + encodeURI(surveys[s].survey_link) + "'>" +
                               esc(trunc(surveys[s].title,20)) +
                            "</a>" +
                        "</div>" +
                        "<div class='card-body'>" + 
                            "<p class='card-text'>" +
                                esc(trunc(surveys[s].description,60)) +
                            "</p>"+
                        "</div>" +
                    "</div>" +
                "</div>";
    }
    e.innerHTML=html;
}
function loadPagination()
{
    pgPrev = document.querySelector("#pg-prev");
    pgNext = document.querySelector("#pg-next");
    pg1 = document.querySelector("#pg-1");
    pg2 = document.querySelector("#pg-2");
    pg3 = document.querySelector("#pg-3");
    pgLnk1 = document.querySelector("#pg-lnk-1");
    pgLnk2 = document.querySelector("#pg-lnk-2");
    pgLnk3 = document.querySelector("#pg-lnk-3");

    pgLnk1.innerHTML=(currentPage-1).toString();
    pgLnk2.innerHTML=currentPage.toString();
    pgLnk3.innerHTML=(currentPage+1).toString();
    pg1.classList.remove("disabled");
    pg1.classList.remove("d-none");
    pg2.classList.remove("disabled");
    pg3.classList.remove("disabled");
    pg3.classList.remove("d-none");
    pgPrev.classList.remove("disabled");
    pgNext.classList.remove("disabled");
    if(currentPage<2)
    {
        pgPrev.classList.add("disabled");
        pg1.classList.add("disabled");
        pg1.classList.add("d-none");
    }
    if(currentPage*maxPerPage>=lenSurveys || lenSurveys<maxPerPage)
    {
        pgNext.classList.add("disabled");
        pg3.classList.add("disabled");
        pg3.classList.add("d-none");
    }
}

function esc(s)
{
    let t= document.createElement('span');
    t.innerText=s;
    return t.outerHTML;
}

function trunc(string,len){
    if (string.length > len)
       return string.substring(0,len)+'...';
    else
       return string;
 };