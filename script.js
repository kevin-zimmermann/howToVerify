window.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form');

    //On regarde si notre page contient un formulaire
    if (form) {
        const processFile = "traitement.php";
        checkValueForm(processFile, form);
        getAllUsers(processFile);
        submittedForm(processFile, form);
    }

    // Cette fonction va nous permettre de récupérer tous les utilisateurs en BDD (cf: traitement.php)
    function getAllUsers(action) {
        let divContent = fetch(action + '?users=1', {

            //On utilise cette method car nous cherchons à récupérer une information
            method: 'GET',
        })
            .then(response => {
                return response.json()
            })
            .then(data => {
                // Création du bloc en HTML qui contiendra les logins de tous les utilisateurs
                let divMaster = document.createElement('div');
                divMaster.setAttribute('id', 'content-users');
                    data.data.forEach(element => {
                        let div = document.createElement('div');
                        let p = document.createElement('p');
                        let button = document.createElement('input');
                        div.setAttribute('class', 'user' + element.id)
                        button.setAttribute("type", "button")
                        button.setAttribute('data-id', element.id);
                        button.setAttribute("name", 'deleteUser');
                        button.value = "Supprimer";
                        p.innerHTML = element.login;
                        div.append(p, button)
                        divMaster.append(div)
                        form.after(divMaster)

                        deleteUser(action);
                    })


            }).catch(error => {
                console.log(error);
            });

    }
//Cette fonction va nous permettre de supprimer un utilisateur en BDD en fonction de son ID et
    function deleteUser(action) {
        let deleteButtons = document.querySelectorAll('input[name="deleteUser"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', event => {
                const userId = button.getAttribute('data-id');
                fetch(action, {
                    method: 'POST', body: JSON.stringify({'deleteUser': userId})
                })
                    .then(response => {
                        return response.json()
                    })
                    .then(data => {
                        console.log(data);
                        //Va supprimer dans notre DOM l'élément qui contient l'utilisateur qui vient d'être supprimer
                        event.target.parentNode.remove();
                    })
                    .catch(err => console.error(err))
            });
        });
    }
//Va nous permettre de vérifier en temps réel notre input (login) pour savoir si il existe en BDD
    function checkValueForm(action, form) {
        for (let i = 0; i < form.length; i++) {
            let p = document.createElement('p');
            p.innerHTML = '';

            form[i].addEventListener('keyup', (e) => {
                e.preventDefault();
                if (form[i].name === "login") {
                    if (form[i].value !== '') {

                        let dataForm = getDataForm(form);

                        fetch(action, {
                            //Cette method va nous permettre d'envoyer de la donnée à notre fichier de traitement (traitement.php)
                            method: 'POST',
                            // Le dataForm contient toutes les informations de tous les inputs (utile si on veut vérifier l'email et login de l'utilisateur pour savoir si ils existent déjà en BDD)
                            body: dataForm,
                            headers: {
                                'Content-type': "multipart/form-data; charset=UTF-8",
                            }
                        })
                            .then(response => {
                                return response.json()
                            })
                            .then(data => {
                                p.innerHTML = data.err;
                                form.append(p);

                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }else{
                        p.innerHTML = '';
                    }
                }


            })
        }
    }

    //Va nous permettre d'envoyer notre formulaire
    function submittedForm(action, form) {
        const submitButton = document.getElementsByName('valider');
        submitButton[0].addEventListener('click', (e) => {
            e.preventDefault();
            let p = document.createElement('p');
            let dataForm = getDataForm(form);

            fetch(action + '?valider=1', {
                method: 'POST', body: dataForm, headers: {
                    'Content-type': "multipart/form-data; charset=UTF-8",
                }
            })
                .then(response => {
                    return response.json()
                })
                .then(data => {
                    console.log(data)

                })


        })
    }

    // Fonction qui va nous permettre de récupérer nos Input dans notre form et de le mettre au bon format pour être exploitable dans le body

    function getDataForm(form) {
        let formData = new FormData(form);
        let object = {};

        formData.forEach((value, key) => object[key] = value);
        let json = JSON.stringify(object);
        return json;
    }

})



