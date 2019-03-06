function downloadNow(){
    if(document.readyState === "complete") {
        let link=document.getElementById("download_link");
        let rows=JSON.parse(link.dataset.answers);
        let universalBOM = "\uFEFF";
        let csvContent = "data:text/csv;charset=utf-8,"+universalBOM;
        rows=rows.map(i=>i.map(j=>j="\""+j+"\"").join(","));
        for(i=0;i<rows.length-1;i++)
            csvContent+=rows[i]+"\r\n";
        csvContent+=rows[rows.length-1];//bez novog reda na kraju
        var encodedUri = encodeURI(csvContent);
        link["href"]= encodedUri;
        link["download"]= link.dataset.fileName;
    }
    else
    {
        window.alert("Sačekajte da se stranica učita, pa probajte ponovo!");
    }
};