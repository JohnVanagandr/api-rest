import { Modal } from 'bootstrap';


const table = document.querySelector("#tableClients");
const $template = document.getElementById("clients").content;
const fragmento = document.createDocumentFragment();
const formSabeClient = document.querySelector('#formSabeClient');
const sabeClientModal = document.querySelector("#sabe-client-modal");
const myModalEl = document.getElementById('createModalClient')
const closeModal = document.querySelector('#closeModal');

const modal = new Modal(myModalEl)

const clientes = async () => {
    const response = await fetch("/oauth/clients");
    const data = await response.json();
    listar(data);
}

const listar = (response) => {

    response.forEach((element) => {
        console.log(element);
        $template.querySelector(".client_id").textContent = element.id;
        $template.querySelector(".name").textContent = element.name;
        $template.querySelector(".secret").textContent = element.secret;

        let clone = document.importNode($template, true);
        fragmento.appendChild(clone);
    });
    table.querySelector('tbody').appendChild(fragmento)
}

const saveClient = async () => {
    const data = {
        'name': document.querySelector("#name").value,
        'redirect': document.querySelector('#redirect').value,
        '_token': formSabeClient.querySelector('[type=hidden]').value
    }
    const form = await fetch('/oauth/clients', {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8",
        },
    });
    let nodes = table.querySelector('tbody');
    while (nodes.firstChild) {
        nodes.removeChild(nodes.firstChild);
    }
  clientes()
  modal.hide();
}

addEventListener("DOMContentLoaded", (event) => {
      clientes();
  });

  sabeClientModal.addEventListener('click', saveClient);

  closeModal.addEventListener('click', function() {
    modal.hide();
  })

  myModalEl.addEventListener('shown.bs.modal', () => {
      document.querySelector("#name").focus();
  })



closeModal.addEventListener('click', function() {
    modal.hide()
})
// console.log(Modal);