$(document).ready(function(){

    document.querySelectorAll('.viewResultSheetButton').forEach(function (item) {
        let url = item.getAttribute('href');

        url = url.replace('classArmId', item.getAttribute('data-desc'));

        url = url.replace('studentId', item.getAttribute('data-id'));

        item.setAttribute('href', url)
    })

});
