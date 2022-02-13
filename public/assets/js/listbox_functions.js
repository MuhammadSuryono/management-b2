<script>
//Doubleclick Available utk tambah anggota
function c_availableid() {
    var select_available = document.getElementById("availableid");
    var select_anggota = document.getElementById('anggotaid');
    var opt = document.createElement('option');
    opt.appendChild(document.createTextNode(select_available.options[select_available.selectedIndex].text));
    opt.value = select_available.options[select_available.selectedIndex].value;
    select_anggota.appendChild(opt);
    select_available.removeChild(select_available[select_available.selectedIndex]);
    sortSelectOptions("#anggotaid");
    //save table di sini ?

}
//Doubleclick Anggota utk menghapus anggota
function c_anggotaid() {
    var select_anggota = document.getElementById("anggotaid");
    var select_available = document.getElementById('availableid');
    var opt = document.createElement('option');
    opt.appendChild(document.createTextNode(select_anggota.options[select_anggota.selectedIndex].text));
    opt.value = select_anggota.options[select_anggota.selectedIndex].value;
    select_available.appendChild(opt);
    select_anggota.removeChild(select_anggota[select_anggota.selectedIndex]);
    sortSelectOptions("#availableid");
    //save table di sini ?

}

function sortSelectOptions(selectElement) {
    var options = $(selectElement + " option");
    options.sort(function(a, b) {
        if (a.text.toUpperCase() > b.text.toUpperCase()) return 1;
        else if (a.text.toUpperCase() < b.text.toUpperCase()) return -1;
        else return 0;
    });
    $(selectElement).empty().append(options);
}
</script>