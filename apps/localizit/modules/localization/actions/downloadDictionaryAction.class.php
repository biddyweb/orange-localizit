<?php

/**
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2011 Orange-localizit Inc., http://www.orange-localizit.com
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
 * Orange-localizit  is a System that transalate text into a any language.
 * Copyright (C) 2011 Orange-localizit Inc., http://www.orange-localizit.com
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
 * This action download language dictionary file for selected target language
 *
 * @author Chameera S
 */
class downloadDictionaryAction extends sfAction {

    private $localizationService;

    /**
     * This method is executed before each action
     */
    public function preExecute() {
        $this->localizationService = $this->getLocalizationService();
    }

    /**
     * Get Localization Service
     */
    public function getLocalizationService() {
        $this->localizationService = new LocalizationService();
        $this->localizationService->setLocalizationDao(new LocalizationDao());
        return $this->localizationService;
    }

    /**
     * Download XML Method.
     * @param <type> $request
     */
    public function execute($request) {

        if ($request->isMethod(sfRequest::GET)) {
            $targetLanguageId = $request->getParameter('targetLanguageId');
            $lanagueGroupId = $request->getParameter('languageGroupId');
            $targetLanguageCode = $this->localizationService->getLanguageById($targetLanguageId)->getCode();
            $sourceLanguageCode = $this->getUser()->getCulture();
            $lanagueGroup = $this->localizationService->getGroupById($lanagueGroupId);

            $file = "language_files/messages_" .$lanagueGroup.".".$targetLanguageCode . ".xml";

            if (!file_exists($file)) {
                $this->getUser()->setFlash('errorMessage', 'Language File Not Found');
                $this->redirect('@homepage');
            }

            if (file_exists($file)) {
                try {
                    $result = $this->localizationService->downloadDictionary($file);

                    if (!$result) {
                        $this->getResponse()->setError('Error');
                    }
                } catch (Exception $ex) {
                    $this->getResponse()->setError('Error');
                }
            }
        }

        $this->setTemplate('index');
    }

}