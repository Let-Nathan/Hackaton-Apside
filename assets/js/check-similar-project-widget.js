const description = document.querySelector('#project_description');
const projectList = document.querySelector('#similar-projects-list');

description.addEventListener('input', () => {
    if (description.value !== '') {
        fetch(`/api/projects/similar/${description.value}`)
            .then(data => data.json())
            .then(result => {
                if (result.length) {
                    const msg = `<h2><p class="ai-icon-anim text-center">Warning</p><p>There is/are ${result.length} project/s that seem to be similar! Please check them before creating from scratch to avoid</p></h2>`;
                    projectList.innerHTML = msg;
                    document.querySelector('#ai-icon').classList.add('ai-icon-anim');
                } else {
                    projectList.innerHTML = '';
                    document.querySelector('#ai-icon').classList.remove('ai-icon-anim');
                }

                console.log(result);
                result.forEach(project => {
                    const newEl = document.createElement('li');
                    newEl.innerHTML = `
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header border-bottom-0">
                                <h5 class="modal-title">${project.title}</h5>
                            </div>
                            <div class="modal-body py-0">
                                <h2 class="modal-title">${project.subject}</h2>
                                <p>${project.description}</p>
                                </div>
                            <div class="modal-footer flex-column border-top-0">
                                <a href="/project/${project.id}" target="_blank" class="btn btn-lg btn-primary w-100 mx-0 mb-2">View project</a>
                            </div>
                        </div>
                    `;
                    projectList.appendChild(newEl);
                });
            });
    } else {
        projectList.innerHTML = '';
    }

});
