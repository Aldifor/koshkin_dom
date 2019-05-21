var regem =/.+@.+\..+/;
var regpas =  /.{8,}/;
var val_em = document.querySelector("#val_em");
var inval_em = document.querySelector("#inval_em");

var val_pas = document.querySelector("#val_pas");
var inval_pas = document.querySelector("#inval_pas");

var val_password = document.querySelector("#val_password");
var inval_password = document.querySelector("#inval_password");

function clickProf(el){
    idProf = el.options[el.selectedIndex].value;
}

function logtest(el){
    var logtest = el.value;
    if(logtest !=""){
        if(regem.test(logtest)){
            $.ajax({
                    url:"?r=accont/register",
                    type:"POST",
                    data:"logtest="+logtest,
                    success:function(data){
                        console.log(data);
                        data = jQuery.parseJSON(data);
                        if(data.length!=0){
                            if((data[0]['login'] == logtest)){
                                el.classList.add("is-invalid");
                                inval_em.innerHTML = "Такой логин уже существует";
                                val_em.innerHTML = "";
                            }
                            else{
                                el.classList.add("is-valid");
                                val_em.innerHTML = "Ок";
                                inval_em.innerHTML = "";
                            }
                        }
                    }
                })
        }
        else{
            el.classList.add("is-invalid");
            inval_em.innerHTML = "Введенный E-mail не корректен";
            val_em.innerHTML = "";
        }
    }
    else{
            val_em.innerHTML = "";
            inval_em.innerHTML = "";
    }
}
function check_pass_valid(el){
    if(regpas.test(el.value)){
        el.classList.add("is-valid");
        val_password.innerHTML = "Хороший пороль";
        inval_password.innerHTML = "";
    }
    else{
        el.classList.add("is-invalid");
        inval_password.innerHTML = "Пороль слишком короткий, введите 8 символов минимум";
        val_password.innerHTML = "";
    }
}
function check_pass(el){
    var pas = document.querySelector("#pas");

    if (pas.value != "" && el.value!= "" ){
        if(pas.value == el.value){
            el.classList.add("is-valid");
            val_pas.innerHTML = "";
            inval_pas.innerHTML = "";
        }
        else{
            el.classList.add("is-invalid");
            val_pas.innerHTML = "";
            inval_pas.innerHTML = "Пороли не савподают";
        }
    }
    else{
        val_pas.innerHTML = "";
        inval_pas.innerHTML = "";
    }
}
function checkForm(form){
    var pas = md5(form.password.value);
    var pas_rep  = md5(form.password_repet.value);
    var name = form.name.value;
    var email = form.email.value;
    var nic = form.nic.value;
    var prof = form.prof.value;
    
    if(pas == pas_rep && regem.test(email) && regpas.test(pas) && prof != 0 && nic != "" && name != ''){
        var form  = {
            'nic': nic,
            'name': name,
            'email': email,
            'prof': prof,
            'pas': pas,
            'pas_rep': pas_rep,
        };
        // console.log(form);
        $.ajax({
            url:"?r=accont/register",
            type:"POST",
            data:"logtest="+email,
            success:function(data){
                data = jQuery.parseJSON(data);
                if(data['login'] == email){
                    return false;
                }
                else{
                    $.ajax({
                        url:"?r=accont/register",
                        type:"POST",
                        data: form,
                        success:function(resp){
                            console.log(resp);
                            window.location.href = "/";
                            return true;
                        }
                    })
                }
            }
        })
    return false;

    }
    else return false;
}