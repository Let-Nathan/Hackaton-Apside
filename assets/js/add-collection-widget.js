const userList = document.querySelector('#user-list');

counter = 0;
userList.addEventListener('click', ev => {
    const newElement = document.createElement('div');

    let markup = document.querySelector('[data-prototype]').dataset.prototype;

    markup = markup.replace(/__name__/g, counter);

    newElement.innerHTML = markup;

    document.querySelector('#project_userProjects').appendChild(newElement);

    console.log(ev.target.closest('li').dataset.userId);
    document.querySelector(`#project_userProjects_${counter}_collaborator`).value = ev.target.closest('li').dataset.userId;
    ev.target.closest('li').classList.add('bg-secondary', 'text-white');

    counter++;
});
