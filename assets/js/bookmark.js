function getBookmarks() {
    fetch(BASE + 'api/bookmarks', { credentials: 'include' })
        .then(result => result.json())
        .then(data => {
            displayBookmarks(data.bookmarks);
        });
}

function addBookmark(surveyId) {
    fetch(BASE + 'api/bookmarks/add/' + surveyId, { credentials: 'include' })
        .then(result => result.json())
        .then(data => {
            if (data.error === 0) {
                getBookmarks();
            }
        });
}

function clearBookmarks() {
    fetch(BASE + 'api/bookmarks/clear', { credentials: 'include' })
        .then(result => result.json())
        .then(data => {
            if (data.error === 0) {
                getBookmarks();
            }
        });
}

function displayBookmarks(bookmarks) {
    const bookmarksDiv = document.querySelector('.bookmarks');
    bookmarksDiv.innerHTML = '';
    if (bookmarks.length === 0) {
        bookmarksDiv.classList.add("dropdown-item");
        bookmarksDiv.classList.add("disabled");
        bookmarksDiv.innerHTML = 'Nema obeležja!';
        return;
    }
    bookmarksDiv.classList.remove("dropdown-item");
    bookmarksDiv.classList.remove("disabled");
    for (bookmark of bookmarks) {
        const bookmarkLink = document.createElement('a');
        bookmarkLink.className='dropdown-item';
        bookmarkLink.innerHTML = bookmark.title;
        bookmarkLink.href = BASE + 'surveys/' + bookmark.survey_link;

        bookmarksDiv.appendChild(bookmarkLink);
    }
}

addEventListener('load', getBookmarks);
