document.addEventListener("DOMContentLoaded", function() {
    // --- إظهار وإخفاء حقول الإعاقات والأمراض ---
    const disabilityCheckbox = document.getElementById('has_disability');
    const disabilitySection = document.getElementById('disability_section');
    if(disabilityCheckbox) {
        disabilityCheckbox.addEventListener('change', function() {
            disabilitySection.style.display = this.checked ? 'block' : 'none';
            if(!this.checked) disabilitySection.querySelector('select').selectedIndex = 0; 
        });
    }

    const chronicCheckbox = document.getElementById('has_chronic_disease');
    const chronicSection = document.getElementById('chronic_disease_section');
    if(chronicCheckbox) {
        chronicCheckbox.addEventListener('change', function() {
            chronicSection.style.display = this.checked ? 'block' : 'none';
            if(!this.checked) chronicSection.querySelector('input').value = ''; 
        });
    }

    // --- ربط صلة القرابة بالجنس وإظهار بيانات الإناث ---
    const relationSelect = document.querySelector('select[name="relation_to_head"]');
    const genderSelect = document.querySelector('select[name="gender"]');
    const femaleOptionsDiv = document.getElementById('female-options');
    const isPregnantCheckbox = document.getElementById('is_pregnant');
    const isBreastfeedingCheckbox = document.getElementById('is_breastfeeding');

    const maleRelations = ['زوج', 'ابن', 'أب', 'أخ', 'حفيد'];
    const femaleRelations = ['زوجة', 'ابنة', 'أم', 'أخت', 'حفيدة'];

    function applyConstraints() {
        const selectedRelation = relationSelect.value;
        if (maleRelations.includes(selectedRelation)) {
            genderSelect.value = 'male';
            lockGenderSelect();
        } else if (femaleRelations.includes(selectedRelation)) {
            genderSelect.value = 'female';
            lockGenderSelect();
        } else {
            unlockGenderSelect(); 
        }

        if (genderSelect.value === 'female') {
            femaleOptionsDiv.style.display = 'block';
        } else {
            femaleOptionsDiv.style.display = 'none';
            if(isPregnantCheckbox) isPregnantCheckbox.checked = false;
            if(isBreastfeedingCheckbox) isBreastfeedingCheckbox.checked = false;
        }
    }

    function lockGenderSelect() {
        genderSelect.style.pointerEvents = 'none';
        genderSelect.style.backgroundColor = '#e9ecef';
    }

    function unlockGenderSelect() {
        genderSelect.style.pointerEvents = 'auto';
        genderSelect.style.backgroundColor = '#fff';
    }

    if(relationSelect) relationSelect.addEventListener('change', applyConstraints);
    if(genderSelect) genderSelect.addEventListener('change', applyConstraints);

    applyConstraints();
});

function updateIndividual(id, familyId) {
    let form = document.getElementById('edit-form');
    if (!form.reportValidity()) return; 

    let formData = new FormData(form);
    formData.append('_method', 'PUT');

    performStore(
        '/individuals/' + id, 
        formData, 
        '/families/' + familyId
    );
}