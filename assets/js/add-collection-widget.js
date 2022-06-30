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
                    newEl.classList.add('btn');
                    newEl.dataset.userId = user.id;
                    newEl.dataset.fullName = user.firstName + ' ' + user.lastName;

                    skillsMarkup = '';
                    user.skills.forEach(el => {
                        skillsMarkup += `<p class="m-0 me-1 bg-light rounded fs-7">${el}</p>`;
                    });

                    newEl.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <img src="${user.img}" style="max-height: 3rem">
                            <div class="d-flex flex-column align-items-start">
                                <p class="m-0 fs-7">${user.firstName + ' ' + user.lastName + ' (' + user.agency + ')'}</p>
                                <p class="m-0 fs-7">${user.email}</p>
                                <div class="d-flex gap-2">
                                    ${skillsMarkup}
                                </div>
                            </div>
                        </div>
                    `;
                    userList.appendChild(newEl);
                });
            });
    } else {
        userList.innerHTML = '';
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
