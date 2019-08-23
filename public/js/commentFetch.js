if (document.getElementById("comment_form") != undefined) {
    const formElt = document.getElementById("comment_form");

    formElt.addEventListener("submit", function(e){
        e.preventDefault();
        let url = 'index.php?action=addComment&id=' + formElt.elements.post_id.value;
        const formData = new FormData(this);

        let options = {
            method: 'post',
            body: formData
        }
        fetch(url , options).then(function (response) {
            return response.text();
        }).then(function (text) {
            let comment = JSON.parse(text);
            commentPrint(comment.user_pseudo, comment.title, comment.content );
        }).catch(function (error) {
            console.error(error);
        })
    });
}

function commentPrint(pseudo, title, content) {
    let commentToDisplay = `
    <div class="col-md-11 mx-auto my-2">
        <div class="row d-flex justify-content-between bg-secondary text-light rounded-top">
            <p class="m-2"><span class="h5 font-italic text-warning">${title}</span> par : <span class="font-weight-bold text-dark">${pseudo}</span></p>
        </div>
        <div class="row">
            <div class="p-2 col-12 bg-light rounded-bottom" >${content}</div>
        </div>
    </div>`;

    window.scrollTo(0,900);
    document.getElementById("comment").insertAdjacentHTML("afterBegin", commentToDisplay);
}
