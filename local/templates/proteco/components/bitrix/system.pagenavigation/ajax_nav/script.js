ra(document).on('click', '[data-action="clickPaginate"]', event => {
    event.preventDefault();
    const elem = event.target;
    var url = elem.tagName === 'A' ? elem.href : elem.closest('a').href;
    var containerTarget = elem.closest('[data-entity="pagination"]');

    if (containerTarget) {
        var containerTargetName = containerTarget.dataset.containerTarget;
        if (containerTargetName) {
            var mutatedContainer = document.querySelector(`[data-entity="${containerTargetName}"]`);
            ra.ajax(url,'GET','',{},'html').then((response) => {
                var container = response.querySelector(`[data-entity="${containerTargetName}"]`);
                var newPagiContainer = response.querySelector('[data-entity="pagination"]');
                mutatedContainer.innerHTML = container.innerHTML;
                containerTarget.innerHTML = newPagiContainer.innerHTML;
            });
        }
    }
})