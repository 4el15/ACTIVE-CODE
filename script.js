const idPasswords = {
    '1160': '01222741403',
    '6680': '01225416886',
    '2700': '01097699815'
};

let codesData = JSON.parse(localStorage.getItem('codesData')) || {};
let currentID = null;
let editingUserID = null;

function checkLogin() {
    const enteredID = document.getElementById('id').value;
    const enteredPassword = document.getElementById('password').value;

    if (idPasswords[enteredID] && idPasswords[enteredID] === enteredPassword) {
        document.getElementById('loginContainer').classList.add('hidden');
        currentID = enteredID;

        if (enteredID === '2700') {
            document.getElementById('adminContainer').classList.remove('hidden');
        } else {
            showCodes(enteredID);
        }
    } else {
        alert('ID أو كلمة المرور غير صحيحة!');
    }
}

function showBoxesForAdmin() {
    const targetID = document.getElementById('adminTargetID').value;
    if (!targetID) {
        alert('يرجى إدخال ID صحيح.');
        return;
    }

    if (!codesData[targetID]) {
        codesData[targetID] = [];
    }

    editingUserID = targetID;
    showCodes(targetID);
}

function showCodes(userID) {
    document.getElementById('boxesContainer').classList.remove('hidden');
    const codes = codesData[userID] || [];
    document.getElementById('codesDisplay').textContent = codes.length;

    const codesDiv = document.getElementById('codes');
    codesDiv.innerHTML = '';

    if (currentID === '2700') {
        document.getElementById('addCodeButton').classList.remove('hidden');
        document.getElementById('saveButton').classList.remove('hidden');
    } else {
        document.getElementById('addCodeButton').classList.add('hidden');
        document.getElementById('saveButton').classList.add('hidden');
    }

    codes.forEach((value, index) => {
        createCode(userID, value, index);
    });
}

function createCode(userID, value = "", index = null) {
    const codesDiv = document.getElementById('codes');

    let input = document.createElement('input');
    input.type = 'text';
    input.value = value;
    input.dataset.index = index !== null ? index : codesData[userID].length;
    input.dataset.userID = userID;

    if (currentID !== '2700') {
        input.readOnly = true;
    }

    codesDiv.appendChild(input);
}

function addCode() {
    if (!editingUserID) return;

    if (!codesData[editingUserID]) {
        codesData[editingUserID] = [];
    }

    codesData[editingUserID].push("");

    showCodes(editingUserID);
}

function saveCodes() {
    if (currentID !== '2700') return;

    const inputs = document.querySelectorAll('#codes input');

    inputs.forEach(input => {
        let userID = input.dataset.userID;
        let index = input.dataset.index;
        codesData[userID][index] = input.value;
    });

    localStorage.setItem('codesData', JSON.stringify(codesData));
    alert('تم حفظ البيانات بنجاح!');
}
