<?php
    namespace Webazon\YandexTranslator;

    class Translator
    {
        const HOST = 'https://translate.api.cloud.yandex.net/translate/v2/translate';
        const HOST_LANG = 'https://translate.api.cloud.yandex.net/translate/v2/languages';
        protected $text;
        protected $ApiKey;
        protected $folder_id;

        /**
         * @param array $arr
         * @throws Exception
         */
        public function __construct(array $arr = [])
        {
            try {

                if (isset($arr['ApiKey']) || isset($arr['IAM_TOKEN'])) {
                    if (isset($arr['folder_id'])) {
                        $target_language = 'ru';
                        $texts = ["Hello, World"];
                        $ApiKey = $arr['ApiKey'];
                        $folder_id = $arr['folder_id'];
                        $headers = [
                          'Content-Type: application/json',
                          "Authorization: Api-Key $ApiKey"
                        ];

                        $post_data = [
                          "targetLanguageCode" => $target_language,
                          "texts" => $texts,
                          "folderId" => $folder_id,
                        ];

                        $data_json = json_encode($post_data);
                        $result = self::Request(self::HOST, $headers, $data_json);
                        if (isset($result['translations'])) {
                            $this->ApiKey = $ApiKey;
                            $this->folder_id = $folder_id;
                            $this->text = $result['translations'][0]['text'];
                        } else {
                            throw new \Webazon\YandexTranslator\Exception($result['message'], $result['code']);
                        }
                    } else {
                        throw new \Webazon\YandexTranslator\Exception('the required parameter `folder_id` is not set');
                    }
                } else {
                    throw new \Webazon\YandexTranslator\Exception('The required `ApiKey` or `IAM_TOKEN` parameter is not set');
                }


            } catch (\Throwable $e) {
                throw new \Webazon\YandexTranslator\Exception($e->getMessage());
            }


        }

        /**
         * @param $text
         * @param $direction
         * @return \stdClass
         * @throws Exception
         */
        public function Translate($text = false, $direction = false): \stdClass
        {
            $res = new \stdClass();
            $res->status = false;
            try {
                if ($direction) {
                    $a = explode('-', $direction);
                    if (isset($a[0])) {
                        $sourceLanguageCode = $a[0];
                    }
                    if (isset($a[1])) {
                        $targetLanguageCode = $a[1];
                    }
                } else {
                    $targetLanguageCode = 'ru';
                }


                $target_language = $targetLanguageCode;

                $texts = [$text];
                $ApiKey = $this->ApiKey;
                $folder_id = $this->folder_id;
                $headers = [
                  'Content-Type: application/json',
                  "Authorization: Api-Key $ApiKey"
                ];

                $post_data = [
                  "targetLanguageCode" => $target_language,
                  "texts" => $texts,
                  "folderId" => $folder_id,
                ];
                if (isset($sourceLanguageCode)) {
                    $post_data['sourceLanguageCode'] = $sourceLanguageCode;
                }

                $data_json = json_encode($post_data);


                $result = self::Request(self::HOST, $headers, $data_json);
                if (isset($result['translations'])) {
                    $res->status = true;
                    $res->text = $result['translations'][0]['text'];
                    if (isset($result['translations'][0]['detectedLanguageCode'])) {
                        $res->sourceLanguageCode = $result['translations'][0]['detectedLanguageCode'];
                    } else {
                        $res->sourceLanguageCode = $sourceLanguageCode;
                    }
                    $res->targetLanguageCode = $target_language;
                } else {
                    throw new \Webazon\YandexTranslator\Exception($result['message'], $result['code']);

                }


            } catch (\Throwable $e) {
                throw new \Webazon\YandexTranslator\Exception($e->getMessage());
            } finally {
                return $res;
            }

        }

        /**
         * @return false|mixed
         * @throws Exception
         */
        public function listLanguages(): mixed
        {
            $res = false;
            try {
                $ApiKey = $this->ApiKey;
                $headers = [
                  'Content-Type: application/json',
                  "Authorization: Api-Key $ApiKey"
                ];
                $folder_id = $this->folder_id;
                $post_data = [

                  "folderId" => $folder_id
                ];
                $data_json = json_encode($post_data);


                $result = self::Request(self::HOST_LANG, $headers, $data_json);

                if (isset($result['languages'])) {

                    $res = $result;
                } else {
                    throw new \Webazon\YandexTranslator\Exception($result['message'], $result['code']);

                }

            } catch (\Throwable $e) {
                throw new \Webazon\YandexTranslator\Exception($e->getMessage());
            } finally {
                return $res;
            }

        }


        static function Request($url, $headers, $data_json)
        {
            try {
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                $result = json_decode(curl_exec($curl), true);
                curl_close($curl);
                return $result;
            } catch (\Throwable $e) {
                throw new \Webazon\YandexTranslator\Exception($e->getMessage());
            }

        }


    }

    ?>