function setSectionFilter(section) {
    const id = section.id;
    if (!id && id === 'all') return false;
    var url = window.location.origin + window.location.pathname + '?SECTION_ID=' + id;
    var mutatedContainer = section.closest('section').querySelector('[data-entity*="container"]');
    const containerName = mutatedContainer ? mutatedContainer.dataset.entity : false;

    if (url && containerName) {
        var pagiContainer = mutatedContainer.parentElement.querySelector('[data-entity="pagination"]');
        ra.ajax(url,'GET','',{},'html').then((response) => {
            var container = response.querySelector(`[data-entity="${containerName}"]`);
            if(container) {
                var newPagiContainer = container.parentElement.querySelector('[data-entity="pagination"]');
                mutatedContainer.className = container.className;
                mutatedContainer.innerHTML = container.innerHTML;
                if(newPagiContainer) {
                    if (pagiContainer) {
                        pagiContainer.innerHTML = newPagiContainer.innerHTML;
                        pagiContainer.style.display = 'grid';
                    } else {
                        mutatedContainer.parentNode.appendChild(newPagiContainer);
                        mutatedContainer.parentNode.querySelector('[data-entity="pagination"]').style.display = 'grid';
                    }
                } else if(pagiContainer) {
                    pagiContainer.style.display = 'none';
                }
            }
        });
    }
}