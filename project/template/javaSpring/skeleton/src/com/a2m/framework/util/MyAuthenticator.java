package com.a2m.framework.util;
/*
* MyAuthenticator.java
* 2002.05.27.
* Hyunho Kim(falllove@ducc.or.kr)
*
* Copyrightⓒ 2002 FancyArts Corps. All rights reserved.
*/

import javax.mail.*;
import javax.mail.internet.*;
import com.sun.mail.smtp.*;
/**
* SMTP Authenticator
*/
class MyAuthenticator extends javax.mail.Authenticator {

    private String id;
    private String pw;

    MyAuthenticator(String id, String pw) {
        this.id = id;
        this.pw = pw;
    }

    protected javax.mail.PasswordAuthentication getPasswordAuthentication() {
        return new javax.mail.PasswordAuthentication(id, pw);
    }

}