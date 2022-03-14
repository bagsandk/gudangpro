<?php

function is_login()
{
    $CI = &get_instance();
    if ($CI->session->userdata('login') != true) {
        redirect('login/index');
    }
}

function is_su()
{
    is_login();
    $CI = &get_instance();
    if ($CI->session->userdata('level') != 'Super Admin') {
        redirect('login/index');
    }
}

function is_admin()
{
    is_login();
    $CI = &get_instance();
    if ($CI->session->userdata('level') != 'Administrator') {
        redirect('login/index');
    }
}

function is_manajer()
{
    is_login();
    $CI = &get_instance();
    if ($CI->session->userdata('level') != 'Manajer') {
        redirect('login/index');
    }
}

function is_keuangan()
{
    is_login();
    $CI = &get_instance();
    if ($CI->session->userdata('level') != 'Keuangan') {
        redirect('login/index');
    }
}

function is_gudang()
{
    is_login();
    $CI = &get_instance();
    if ($CI->session->userdata('level') != 'Gudang') {
        redirect('login/index');
    }
}
