// ajaxの実装をしていくよ

// tests全般の処理
// testの内容が更新される処理を書く
function updateTest(id){
    var yearValue = document.getElementById("year"+id).value;
    var nameValue = document.getElementById("name"+id).value;

    // 表示するためにtdのidを取得する
    var tdYearElement = document.getElementById("testYearTable"+id);
    var tdNameElement = document.getElementById("testNameTable"+id);

    const formData = new FormData();
    formData.append('year',yearValue);
    formData.append('name',nameValue);
    formData.append('id',id);

    const req = new XMLHttpRequest();
    req.open('POST','../tests/update.php',true);
    req.send(formData);

    req.onreadystatechange = function() {
        if(req.readyState == 4){
        if(req.status == 200){
            tdYearElement.textContent = yearValue;
            tdNameElement.textContent = nameValue;
            console.log('更新完了');
        }
        }else{
        console.log('更新処理中です');
        }
    }
}
// testの内容が削除される処理を書く
function deleteTest(id){
    var trElement = document.getElementById("testContent"+id);

    const formData = new FormData();
    formData.append('id',id);

    const req = new XMLHttpRequest();
    req.open('POST','../tests/delete.php',true);
    req.send(formData);

    req.onreadystatechange = function() {
        if(req.readyState == 4){
        if(req.status == 200){
            trElement.parentNode.removeChild(trElement);
            console.log('更新完了');
        }
        }else{
        console.log('更新処理中です');
        }
    }
}

// students全般の処理
// studentの更新処理を書く（基本的にはtestと同じ）
function updateStudent(id){
    var numberValue = document.getElementById("number"+id).value;
    var nameValue = document.getElementById("name"+id).value;
    var classIdValue = document.getElementById("class_id"+id).value;

    // 表示するためにtdのidを取得する
    var tdNumberElement = document.getElementById("studentNumberTd"+id);
    var tdNameElement = document.getElementById("studentNameTd"+id);
    var tdClassIdElement = document.getElementById("studentClassIdTd"+id);

    const formData = new FormData();
    formData.append('class_id',classIdValue);
    formData.append('number',numberValue);
    formData.append('name',nameValue);
    formData.append('id',id);

    const req = new XMLHttpRequest();
    req.open('POST','../students/update.php',true);
    req.send(formData);

    req.onreadystatechange = function() {
        if(req.readyState == 4){
        if(req.status == 200){
            tdNumberElement.textContent = numberValue;
            tdNameElement.textContent = nameValue;
            tdClassIdElement.textContent = classIdValue;
            console.log('更新完了');
        }
        }else{
        console.log('更新処理中です');
        }
    }
}
// 生徒の削除処理をする
function deleteStudent(id){
    var trElement = document.getElementById("studentContent"+id);

    const formData = new FormData();
    formData.append('id',id);

    const req = new XMLHttpRequest();
    req.open('POST','../students/delete.php',true);
    req.send(formData);

    req.onreadystatechange = function() {
        if(req.readyState == 4){
        if(req.status == 200){
            trElement.parentNode.removeChild(trElement);
            console.log('更新完了');
        }
        }else{
        console.log('更新処理中です');
        }
    }
}

// exam全般の処理
// 登録・修正するときの合計点の計算
function calcTotal(examId){
    const kokugo = document.querySelector(`#kokugo${examId}`);
    const sugaku = document.querySelector(`#sugaku${examId}`);
    const eigo = document.querySelector(`#eigo${examId}`);
    const rika = document.querySelector(`#rika${examId}`);
    const shakai = document.querySelector(`#shakai${examId}`);
    const goukei = document.querySelector(`#goukei${examId}`);
    
    goukei.value = Number(kokugo.value) + Number(sugaku.value) + Number(eigo.value) + Number(rika.value) + Number(shakai.value);
}
// examの更新処理
function updateExam(id){
    var kokugoValue = document.getElementById("kokugo"+id).value;
    var sugakuValue = document.getElementById("sugaku"+id).value;
    var eigoValue = document.getElementById("eigo"+id).value;
    var rikaValue = document.getElementById("rika"+id).value;
    var shakaiValue = document.getElementById("shakai"+id).value;
    var goukeiValue = document.getElementById("goukei"+id).value;

    // 表示するためにtdのidを取得する
    var tdKokugoElement = document.getElementById("examKokugoTd"+id);
    var tdSugakuElement = document.getElementById("examSugakuTd"+id);
    var tdEigoElement = document.getElementById("examEigoTd"+id);
    var tdRikaElement = document.getElementById("examRikaTd"+id);
    var tdShakaiElement = document.getElementById("examShakaiTd"+id);
    var tdGoukeiElement = document.getElementById("examGoukeiTd"+id);

    const formData = new FormData();
    formData.append('kokugo',kokugoValue);
    formData.append('sugaku',sugakuValue);
    formData.append('eigo',eigoValue);
    formData.append('rika',rikaValue);
    formData.append('shakai',shakaiValue);
    formData.append('goukei',goukeiValue);
    formData.append('id',id);

    const req = new XMLHttpRequest();
    req.open('POST','../exams/update.php',true);
    req.send(formData);

    req.onreadystatechange = function() {
        if(req.readyState == 4){
        if(req.status == 200){
            tdKokugoElement.textContent = kokugoValue;
            tdSugakuElement.textContent = sugakuValue;
            tdEigoElement.textContent = eigoValue;
            tdRikaElement.textContent = rikaValue;
            tdShakaiElement.textContent = shakaiValue;
            tdGoukeiElement.textContent = goukeiValue;
            console.log('更新完了');
        }
        }else{
        console.log('更新処理中です');
        }
    }
}
// examの削除処理
function deleteExam(id){
    var trElement = document.getElementById("examContent"+id);

    const formData = new FormData();
    formData.append('id',id);

    const req = new XMLHttpRequest();
    req.open('POST','../exams/delete.php',true);
    req.send(formData);

    req.onreadystatechange = function() {
        if(req.readyState == 4){
        if(req.status == 200){
            trElement.parentNode.removeChild(trElement);
            console.log('更新完了');
        }
        }else{
        console.log('更新処理中です');
        }
    }
}