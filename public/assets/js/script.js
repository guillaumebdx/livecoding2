const resultParagraph = document.getElementById('result')
let buttons = document.getElementsByClassName('heart');
for (let i =0; i < buttons.length ; i++) {
    buttons[i].addEventListener('click', function() {
        fetch(
            '/user/favorite',
            {
                method: 'post',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'item': buttons[i].getAttribute('data-item'),
                    'user': buttons[i].getAttribute('data-user')
                }),
            })
            .then(response => response.json())
            .then(data => resultParagraph.innerHTML = data.id + " a bien été ajouté", resultParagraph.classList.add('alert-success'))
            .catch((e) => console.log(e))
    })
}