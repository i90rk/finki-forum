<?php

function printLoginUserModal() {
	echo '
    <div id="loginModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    	<div class="modal-header">
        	<button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="loginModalLabel">Најави се</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputEmail">Корисничко име</label>
                    <div class="controls">
                        <input type="text" id="inputUsername" placeholder="Корисничко име">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPassword">Лозинка</label>
                    <div class="controls">
                        <input type="password" id="inputPassword" placeholder="Лозинка">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <span id="login_user_error" class="status_error_messages alert" style="display:none"></span>
            <button id="close_login_modal" class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="login_btn" class="btn btn-primary">најави се</button>
        </div>
    </div>
	';
}

function printRegisterUserModal() {
	echo '
    <div id="registerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    	<div class="modal-header">
            <button type="button" class="close close_modal" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="registerModalLabel">Регистрирај се</h3>
        </div>
        <div class="modal-body">
            <form class="form-horizontal" enctype="multipart/form-data">
                <div class="control-group">
                    <label class="control-label">Име: </label>
                    <div class="controls">
                        <input type="text" id="add_firstname" name="add_firstname" placeholder="Име">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Презиме: </label>
                    <div class="controls">
                        <input type="text" id="add_lastname" name="add_lastname" placeholder="Презиме">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Корисничко име: </label>
                    <div class="controls">
                        <input type="text" id="add_username" class="add_username" placeholder="Корисничко име">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Лозинка: </label>
                    <div class="controls">
                        <input type="password" id="add_password" class="add_password" placeholder="Лозинка">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Потврди лозинка: </label>
                    <div class="controls">
                        <input type="password" id="add_password_confirm" class="add_password_confirm" placeholder="Потврди лозинка">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Еmail-адреса: </label>
                    <div class="controls">
                        <input type="text" id="add_email" class="add_email" placeholder="Еmail-адреса">
                    </div>
                </div>    
            </form>
        </div>
        <div class="modal-footer">
            <span id="register_user_error" class="status_error_messages alert" style="display:none"></span>
            <button class="btn close_modal" data-dismiss="modal" aria-hidden="true">затвори</button>
            <button id="register_btn" class="btn btn-primary">регистрирај се</button>
        </div>
    </div>
	';
}

function beforeLoginMenu() {
    echo '
        <div>
            <div id="loginModalBtn" class="menu"><a href="#"><img src="' . base_url() . 'resources/css/images/btn_mk_login.png"/></a></div>
            <div id="registerModalBtn" class="menu"><a href="#"><img src="' . base_url() . 'resources/css/images/btn_mk_register.png"/></a></div>
        </div>
    ';
}

function afterLoginMenu($session) {
    echo '
        <div>
            <div class="menu"><a href="' . base_url() . 'global_actions/userLogout"><img src="' . base_url() . 'resources/css/images/btn_mk_logout.png"/></a></div>
            <div class="menu"><a href="' . base_url() . 'user_settings/userSettings/' . $session['id'] . '"><img src="' . base_url() . 'resources/css/images/btn_mk_settings.png"/></a></div>
            <div class="menu"><a href="' . base_url() . 'user_profile/userProfile/' . $session['id'] . '"><img src="' . base_url() . 'resources/css/images/btn_mk_profile.png"/></a></div>
        </div>
    ';
}

function forumHeader() {
    echo '
        <div class="forumTitle">
            <a href="http://www.ukim.edu.mk/">
                <img src="' . base_url() . 'resources/css/images/ukim-logo-9.png"/>
            </a>
            <a href="http://www.finki.ukim.mk/mk/home">
                <img src="' . base_url() . 'resources/css/images/finki-logo-9.png"/>
            </a>
        </div>
    ';
}

function loggedInNotification($session) {
    if(isset($session['loggedin']) && $session['loggedin'] == TRUE) {
        echo '
        <div class="alert alert-info" id="loginAlert">
            Добредојдовте назад, <b><a href="' . base_url() . 'user_profile/userProfile/' . $session['id']->{'$id'} . '" class="headerLink">' . $session['username'] . '</a></b>.
        </div>';
    } else {
        echo '
        <div class="alert alert-info" id="loginAlert">
            Добредојдовте на ФИНКИ форумот. Потребно е да се <a href="#" class="headerLink">најавите</a> или <a href="#" class="headerLink">регистрирате</a> за да учествувате во дискусиите !!
        </div>';
    }
}

function forumFooter() {
    echo '
        <footer>
            <div class="left_section_wrapper">
                <div class="left_section">
                    <h2>за нас</h2>
                    <div class="custom-footer">
                        <img src="' . base_url() . 'resources/css/images/logo-finki-footer-white.png">
                    </div>
                    <div class="custom-footer">
                        <p>Факултет за информатички науки и компјутерско инженерство</p>
                        <p>ул. „Руѓер Бошковиќ“ 16</p>
                        <p>Поштенски Фах 393</p>
                        <p>1000 Скопје, Република Македонија</p> 
                        <p>contact@finki.ukim.mk</p>
                    </div>
                </div>
            </div>
            <div class="right_section_wrapper">
                <div class="right_section">
                    <h2>следете не</h2>
                    <ul>
                        <li><a class="twitter" target="_blank" href="https://twitter.com/FINKIedu"></a></li>
                        <li><a class="facebook" target="_blank" href="https://www.facebook.com/FINKI.ukim.mk"></a></li>
                        <li><a class="youtube" target="_blank" href="http://www.youtube.com/user/FINKIedu"></a></li>
                    </ul>
                </div>
            </div>           
        </footer>
    ';
}

?>