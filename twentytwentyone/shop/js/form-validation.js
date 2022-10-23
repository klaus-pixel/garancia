document.addEventListener('DOMContentLoaded', function(e){

    let produktForm = this.getElementById('contactform');
    const areaSelect = produktForm.querySelector('[name="categoryselect"]');
    var product_type;
    var product;
    areaSelect.addEventListener('change', (e) => {
        // log(`e.target`, e.target);
        const select = e.target;
        const value = select.value;
        product_type = select.selectedOptions[0].text;
      });
    produktForm.addEventListener('submit', (e) => {

        e.preventDefault();

        //reset the form messages

        resetMessages();

        //collect all the data

        let data = {
            name: produktForm.querySelector('[name="name"]').value,

            email: produktForm.querySelector('[name="email"]').value,

            subjekt: produktForm.querySelector('[name="subject"]').value,

            nrId: produktForm.querySelector('[name="id"]').value,

            tipi: product_type,

            produkti: produktForm.querySelector('[name="produktselect"]').innerText,

            messazhi: produktForm.querySelector('[name="message"]').value,
        }

        console.log(data.produkti);

        //validate the everything

        if(! data.name){

            produktForm.querySelector('[data-error="invalidName"]').classList.add('show');
            
            return;
        }

        if(! validateEmail(data.email)){

            produktForm.querySelector('[data-error="invalidEmail"]').classList.add('show');
            
            return;
        }

        if(! data.subjekt){

            produktForm.querySelector('[data-error="invalidSubjekt"]').classList.add('show');
            
            return;
        }

        if(! data.nrId){

            produktForm.querySelector('[data-error="invalidId"]').classList.add('show');
            
            return;
        }

        if(! data.produkti){

            produktForm.querySelector('[data-error="invalidProdukt"]').classList.add('show');
            
            return;
        }

        if(! data.messazhi){

            produktForm.querySelector('[data-error="invalidMessage"]').classList.add('show');
            
            return;
        }


        //ajax http post request to backend
        let url = produktForm.dataset.url;
        let params = new URLSearchParams(new FormData(produktForm));
        console.log(url);  
        produktForm.querySelector('.js-form-submission').classList.add('show')

		fetch(url, {
			method: "POST",
			body: params
		}).then(res => res.json())
			.catch(error => {
				resetMessages();
				produktForm.querySelector('.js-form-error').classList.add('show');
			})
			.then(response => {
				resetMessages();
				
				if (response === 0 || response.status === 'error') {
					produktForm.querySelector('.js-form-error').classList.add('show');
					return;
				}

				produktForm.querySelector('.js-form-success').classList.add('show');

				produktForm.querySelector('[name="name"]').value = '';

                produktForm.querySelector('[name="email"]').value = '';

                produktForm.querySelector('[name="subject"]').value =  '';

                produktForm.querySelector('[name="id"]').value = '';

                produktForm.querySelector('[name="produktselect"]').value = '';

                produktForm.querySelector('[name="produktselect"]').value = '';

                produktForm.querySelector('[name="message"]').value = '';
        
			})

    });
});

//Rifresko mesazhet
function resetMessages(){
    document.querySelectorAll('.field-msg').forEach(field =>{

        field.classList.remove('show');
    })
}

//REGEX email validation
function validateEmail(email){
;
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}