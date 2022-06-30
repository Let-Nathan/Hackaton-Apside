const userList = document.querySelector('#user-list');

counter = 0;
userList.addEventListener('click', ev => {
    const newElement = document.createElement('div');

    let markup = document.querySelector('[data-prototype]').dataset.prototype;

    markup = markup.replace(/__name__/g, counter);

    newElement.innerHTML = markup;

    document.querySelector('#project_userProjects').appendChild(newElement);

    document.querySelector(`#project_userProjects_${counter}_collaborator`).value = ev.target.closest('li').dataset.userId;
    ev.target.closest('li').classList.add('bg-secondary', 'text-white');

    counter++;

    addToSelectionList(ev.target.closest('li'));
});

const addCollaborator = document.querySelector('#add-collaborator');
addCollaborator.addEventListener('input', () => {

    if (addCollaborator.value !== '') {
        fetch(`/api/users/${addCollaborator.value}`)
            .then(data => data.json())
            .then(result => {
                userList.innerHTML = '';
                result.users.forEach(user => {
                    newEl = document.createElement('li');
                    newEl.classList.add('shadow', 'btn');
                    newEl.dataset.userId = user.id;
                    newEl.dataset.fullName = user.firstName + ' ' + user.lastName;
                    newEl.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <img src="${user.img}" style="max-height: 4rem">
                            <div class="d-flex flex-column align-items-start">
                                <p class="m-0">${user.firstName + ' ' + user.lastName}</p>
                                <p class="m-0">${user.agency}</p>
                                <div class="d-flex gap-2">
                                    <p class="m-0 bg-warning px-2 rounded">php</p>
                                    <p class="m-0 bg-warning px-2 rounded">JavaScript</p>
                                </div>
                            </div>
                        </div>
                    `;
                    userList.appendChild(newEl);
                });
            });
    }
});

function addToSelectionList(el)
{
    const newEl = document.createElement('p');
    newEl.innerHTML = el.dataset.fullName;
    newEl.classList.add('bg-light', 'p-1', 'rounded', 'm-0');
    document.querySelector('#collaborators-selected').appendChild(newEl);

    userList.innerHTML = '';
    addCollaborator.value = '';
}
