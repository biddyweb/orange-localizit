<?php

/**
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2006 Orange-localizit Inc., http://www.orange-localizit.com
 *
 * Orange-localizit is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * Orange-localizit is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

/**
 * Description of loginAction
 *
 * @author waruni
 */
class loginAction extends sfAction {

    /**
     * Login Method. If user provides valid username and password , create a session.
     * @param <type> $request
     */
    public function execute($request) {

        if (!$this->getUser()->isAuthenticated()) {
            $this->signInForm = new SignInForm();

            if ($request->isMethod(sfRequest::POST)) {
                $this->signInForm->bind($request->getParameter($this->signInForm->getName()));
                if ($this->signInForm->isValid()) {

                    // Create Sessions
                    $this->getUser()->setAuthenticated(true);
                    //$this->getUser()->addCredential('Moderator'); moved to SignInForms

                    $signIn = $request->getParameter($this->signInForm->getName());
                    $this->getUser()->setAttribute('username', $signIn['loginName']);
                    
                    $this->redirect('@homepage');
                } {
                    $globalErrors=$this->signInForm->getGlobalErrors();
                    if(count($globalErrors)>0) {
                        foreach ($globalErrors as $name => $error) {
                            $this->getUser()->setFlash('errorMessage', $error, false);
                        }
                    }
                }
            }
        } else {
            $this->redirect('@homepage');
        }
        $this->setTemplate('index');
    }
}