window.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form');

    if (form) {
        const processFile = "traitement.php";
        submittedForm(processFile, form);
        checkValueForm(processFile, form);
    }

    function checkValueForm(action, form) {
        for (let i = 0; i < form.length; i++) {
            console.log(form[i]);
            form[i].addEventListener('keyup', (e) => {
                e.preventDefault();
                let p = document.createElement('p');
                if (form[i].name === "login"){
                    if (form[i].value !== '') {
                        p.innerHTML = '';
                        let data = getDataForm(form);

                        fetch(action, {
                            method: 'POST',
                            body: data,
                            headers: {
                                'Content-type': "multipart/form-data; charset=UTF-8",
                            }
                        })
                            .then(response => {
                                return response.json()
                            })
                            .then(data => {
                                p.innerHTML = data[1];
                                form.append(p);
                                // document.body.innerHTML += data;

                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                }



            })
        }
    }

    function submittedForm(action, form) {
        const submitButton = document.getElementsByName('valider');
        submitButton[0].addEventListener('click', (e) => {
            e.preventDefault();
            let data = getDataForm(form);

            fetch(action + '?valider=1', {
                method: 'POST',
                body: data,

                headers: {
                    'Content-type': "multipart/form-data; charset=UTF-8",
                }
            })
                .then(response => {
                    return response.json()
                })
                .then(data => {
                        location.reload();
                })


        })
    }

    function getDataForm(form) {
        let formData = new FormData(form);
        let object = {};

        formData.forEach((value, key) => object[key] = value);
        let json = JSON.stringify(object);
        return json;
    }

})



