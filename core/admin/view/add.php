<form id="main-form" class="vg-wrap vg-element vg-ninteen-of-twenty" method="post" action="<?=$this->adminPath . $this->action?>"
      enctype="multipart/form-data">
    <div class="vg-wrap vg-element vg-full">
        <div class="vg-wrap vg-element vg-full vg-firm-background-color4 vg-box-shadow">
            <div class="vg-element vg-half vg-left">
                <div class="vg-element vg-padding-in-px">
                    <input type="submit" class="vg-text vg-firm-color1 vg-firm-background-color4 vg-input vg-button" value="Сохранить">
                </div>

                <?php if(!$this->noDelete && $this->data):?>
                    <div class="vg-element vg-padding-in-px">
                        <a href="<?=$this->adminPath . 'delete/' . $this->table . '/' . $this->data[$this->columns['id_row']]?>"
                            class="vg-text vg-firm-color1 vg-firm-background-color4 vg-input vg-button vg-center vg_delete">
                            <span>Удалить</span>
                        </a>
                     </div>
                <?php endif;?>
            </div>
        </div>
    </div>

    <?php if($this->data):?>
        <input id="tableId" type="hidden" name="<?=$this->columns['id_row']?>" value="<?=$this->data[$this->columns['id_row']]?>">
    <?php endif;?>

    <input type="hidden" name="table" value="<?=$this->table?>">

    <?php

        foreach ($this->blocks as $class => $block){

            if(is_int($class)) $class = 'vg-rows';

            echo '<div class="vg-wrap vg-element ' . $class .'">';

            if($class !== 'vg-content') echo '<div class="vg-full vg-firm-background-color4 vg-box-shadow">';

            if($block){

                foreach ($block as $row){

                    foreach ($this->templateArr as $template => $items){

                        if (in_array($row, $items)){

                            if (!@include $_SERVER['DOCUMENT_ROOT'] . $this->formTemplates . $template . '.php'){
                                throw new \core\base\exceptions\RouteException('Не найден шаблон ' .
                                    $_SERVER['DOCUMENT_ROOT'] . $this->formTemplates . $template . '.php');
                            }

                            break;

                        }
                    }
                }
            }
            if ($class !== 'vg-content') echo '</div>';
            echo '</div>';
        }

    ?>

<!--            <div class="vg-element vg-full vg-box-shadow">-->
<!--                <div class="vg-wrap vg-element vg-full vg-box-shadow">-->
<!--                    <div class="vg-wrap vg-element vg-full">-->
<!--                        <div class="vg-element vg-full vg-left">-->
<!--                            <span class="vg-header">Ссылка ЧПУ</span>-->
<!--                        </div>-->
<!--                        <div class="vg-element vg-full vg-left">-->
<!--                            <span class="vg-text vg-firm-color5"></span><span class="vg_subheader"></span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="vg-element vg-full">-->
<!--                        <div class="vg-element vg-full vg-left ">-->
<!--                            <input type="text" name="alias" class="vg-input vg-text vg-firm-color1" value="test-53">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="vg-element vg-full vg-box-shadow img_wrapper">-->
<!--                <div class="vg-wrap vg-element vg-full">-->
<!--                    <div class="vg-wrap vg-element vg-full">-->
<!--                        <div class="vg-element vg-full vg-left">-->
<!--                            <span class="vg-header">new_gallery_img</span>-->
<!--                        </div>-->
<!--                        <div class="vg-element vg-full vg-left">-->
<!--                            <span class="vg-text vg-firm-color5"></span><span class="vg_subheader"></span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="vg-wrap vg-element vg-full gallery_container">-->
<!--                        <label class="vg-dotted-square vg-center" draggable="false">-->
<!--                            <img src="/core/admin/view/img/plus.png" alt="plus" draggable="false">-->
<!--                            <input class="gallery_img" style="display: none;" type="file" name="new_gallery_img[]" multiple="" accept="image/*,image/jpeg,image/png,image/gif" draggable="false">-->
<!--                        </label>-->
<!--                        <a href="/admin/delete/goods/53/new_gallery_img/ODQwLTg0MDMxNjlfZG93bmxvYWQtc3ZnLWRvd25sb2FkLXBuZy1kb2N0b3ItZW1vamlfMDNjYjAwNmQucG5n" class="vg-dotted-square vg-center" draggable="true">-->
<!--                            <img class="vg_delete" src="/userfiles/840-8403169_download-svg-download-png-doctor-emoji_03cb006d.png" draggable="false">-->
<!--                        </a>-->
<!--                        <a href="/admin/delete/goods/53/new_gallery_img/a2lzc3BuZy1lYXJyaW5nLWpld2VsbGVyeS1nZW1zdG9uZS1kaWFtb25kLWdvbGQtcmluZ3MtcG5nLWNsaXBhcnQtNWE3ODIzOTU0NGM0YjMyODg0NTUxMjE1MTc4MjI4NjkyODE3LnBuZw==" class="vg-dotted-square vg-center" draggable="true">-->
<!--                            <img class="vg_delete" src="/userfiles/kisspng-earring-jewellery-gemstone-diamond-gold-rings-png-clipart-5a78239544c4b32884551215178228692817.png" draggable="false">-->
<!--                        </a>-->
<!--                        <div class="vg-dotted-square vg-center empty_container" draggable="false"></div><div class="vg-dotted-square vg-center empty_container" draggable="false"></div>                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="vg-element vg-full vg-left vg-box-shadow">-->
<!--                <div class="vg-wrap vg-element vg-full vg-box-shadow">-->
<!--                    <div class="vg-element vg-full vg-left">-->
<!--                        <span class="vg-header ui-sortable-handle">Фильтры</span>-->
<!--                    </div>-->
<!--                    <div class="vg-element vg-full vg-input vg-relative vg-space-between select_wrap">-->
<!--                        <span class="vg-text vg-left">Color</span>-->
<!--                        <span class="vg-text vg-right select_all">Выделить все</span>-->
<!--                    </div>-->
<!--                    <div class="option_wrap">-->
<!--                        <label class="custom_label" for="25-17">-->
<!--                            <div>-->
<!--                                <input id="25-17" type="checkbox" name="filters[25][17][id]" value="17">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">red</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <label class="custom_label" for="25-18">-->
<!--                            <div>-->
<!--                                <input id="25-18" type="checkbox" name="filters[25][18][id]" value="18">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">green</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <label class="custom_label" for="25-24">-->
<!--                            <div>-->
<!--                                <input id="25-24" type="checkbox" name="filters[25][24][id]" value="24">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">lightred</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="vg-element vg-full vg-input vg-relative vg-space-between select_wrap">-->
<!--                        <span class="vg-text vg-left">height</span>-->
<!--                        <span class="vg-text vg-right select_all">Выделить все</span>-->
<!--                    </div>-->
<!--                    <div class="option_wrap">-->
<!--                        <label class="custom_label" for="29-31">-->
<!--                            <div>-->
<!--                                <input id="29-31" type="checkbox" name="filters[29][31][id]" value="31">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">2px</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <label class="custom_label" for="29-30">-->
<!--                            <div>-->
<!--                                <input id="29-30" type="checkbox" name="filters[29][30][id]" value="30">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">1 px</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <label class="custom_label" for="29-32">-->
<!--                            <div>-->
<!--                                <input id="29-32" type="checkbox" name="filters[29][32][id]" value="32">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">3px</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="vg-element vg-full vg-input vg-relative vg-space-between select_wrap">-->
<!--                        <span class="vg-text vg-left">Width</span>-->
<!--                        <span class="vg-text vg-right select_all">Выделить все</span>-->
<!--                    </div>-->
<!--                    <div class="option_wrap">-->
<!--                        <label class="custom_label" for="26-19">-->
<!--                            <div>-->
<!--                                <input id="26-19" type="checkbox" name="filters[26][19][id]" value="19">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">200mm</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <label class="custom_label" for="26-20">-->
<!--                            <div>-->
<!--                                <input id="26-20" type="checkbox" name="filters[26][20][id]" value="20">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">300mm</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                        <label class="custom_label" for="26-23">-->
<!--                            <div>-->
<!--                                <input id="26-23" type="checkbox" name="filters[26][23][id]" value="23">-->
<!--                                <span class="custom_check backgr_bef"></span>-->
<!--                                <span class="label">400mm</span>-->
<!--                            </div>-->
<!--                        </label>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="vg-wrap vg-element vg-img">-->
<!--        <div class="vg-full vg-firm-background-color4 vg-box-shadow">-->
<!---->
<!--            <div class="vg-wrap vg-element vg-full vg-box-shadow img_container img_wrapper">-->
<!--                <div class="vg-wrap vg-element vg-half">-->
<!--                    <div class="vg-wrap vg-element vg-full">-->
<!--                        <div class="vg-element vg-full vg-left">-->
<!--                            <span class="vg-header">main_img</span>-->
<!--                        </div>-->
<!--                        <div class="vg-element vg-full vg-left">-->
<!--                            <span class="vg-text vg-firm-color5"></span><span class="vg_subheader"></span>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="vg-wrap vg-element vg-full">-->
<!--                        <label for="main_img" class="vg-wrap vg-full file_upload vg-left">-->
<!--                            <span class="vg-element vg-full vg-input vg-text vg-left vg-button" style="float: left; margin-right: 10px">Выбрать</span>-->
<!--                            <a style="color:black" href="/admin/delete/goods/53/main_img/ODQwLTg0MDMxNjlfZG93bmxvYWQtc3ZnLWRvd25sb2FkLXBuZy1kb2N0b3ItZW1vamkucG5n" class="vg-element vg-full vg-input vg-text vg-left vg-button vg_delete">-->
<!--                                <span>Удалить</span>-->
<!--                            </a>-->
<!--                            <input id="main_img" type="file" name="main_img" class="single_img" accept="image/*,image/jpeg,image/png,image/gif">-->
<!--                        </label>-->
<!--                    </div>-->
<!--                    <div class="vg-wrap vg-element vg-full">-->
<!--                        <div class="vg-element vg-left img_show main_img_show">-->
<!--                            <img src="/userfiles/840-8403169_download-svg-download-png-doctor-emoji.png">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="vg-wrap vg-element vg-content">-->
<!--        <div class="vg-wrap vg-element vg-full vg-box-shadow">-->
<!--            <div class="vg-wrap vg-element vg-full vg-box-shadow">-->
<!--                <div class="vg-wrap vg-element vg-full">-->
<!--                    <div class="vg-element vg-full vg-left">-->
<!--                        <span class="vg-header">Описание</span>-->
<!--                    </div>-->
<!--                    <div class="vg-element vg-full vg-left">-->
<!--                        <span class="vg-text vg-firm-color5"></span><span class="vg_subheader"></span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="vg-element vg-full">-->
<!--                    <div class="vg-element vg-full vg-left" style="flex-wrap: wrap">-->
<!--                        <div style="width: 100%; margin-bottom: 10px">-->
<!--                            <label>-->
<!--                                <input type="checkbox" class="tinyMceInit" style="display: inline" checked="">-->
<!--                                Визуальный режим-->
<!--                            </label>-->
<!--                        </div>-->
<!--                        <textarea name="content" class="vg-input vg-text vg-full vg-firm-color1" id="mce_editor_0" aria-hidden="true" style="display: none;">test</textarea><div role="application" class="tox tox-tinymce" aria-disabled="false" style="visibility: hidden; height: 400px;"><div class="tox-editor-container"><div data-alloy-vertical-dir="toptobottom" class="tox-editor-header"><div role="menubar" data-alloy-tabstop="true" class="tox-menubar"><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Файл</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Изменить</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Вид</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Вставить</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Формат</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Инструменты</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button aria-haspopup="true" role="menuitem" type="button" data-alloy-tabstop="true" unselectable="on" tabindex="-1" class="tox-mbtn tox-mbtn--select" aria-expanded="false" style="user-select: none;"><span class="tox-mbtn__select-label">Таблица</span><div class="tox-mbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button></div><div role="group" class="tox-toolbar-overlord" aria-disabled="false"><div role="group" class="tox-toolbar__primary"><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button aria-label="Вернуть" title="Вернуть" type="button" tabindex="-1" class="tox-tbtn tox-tbtn--disabled" aria-disabled="true"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M6.4 8H12c3.7 0 6.2 2 6.8 5.1.6 2.7-.4 5.6-2.3 6.8a1 1 0 01-1-1.8c1.1-.6 1.8-2.7 1.4-4.6-.5-2.1-2.1-3.5-4.9-3.5H6.4l3.3 3.3a1 1 0 11-1.4 1.4l-5-5a1 1 0 010-1.4l5-5a1 1 0 011.4 1.4L6.4 8z" fill-rule="nonzero"></path></svg></span></button><button aria-label="Отменить" title="Отменить" type="button" tabindex="-1" class="tox-tbtn tox-tbtn--disabled" aria-disabled="true"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M17.6 10H12c-2.8 0-4.4 1.4-4.9 3.5-.4 2 .3 4 1.4 4.6a1 1 0 11-1 1.8c-2-1.2-2.9-4.1-2.3-6.8.6-3 3-5.1 6.8-5.1h5.6l-3.3-3.3a1 1 0 111.4-1.4l5 5a1 1 0 010 1.4l-5 5a1 1 0 01-1.4-1.4l3.3-3.3z" fill-rule="nonzero"></path></svg></span></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button title="Формат" aria-label="Формат" aria-haspopup="true" type="button" unselectable="on" tabindex="-1" class="tox-tbtn tox-tbtn--select tox-tbtn--bespoke" aria-expanded="false" style="user-select: none;"><span class="tox-tbtn__select-label">Параграф</span><div class="tox-tbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button aria-label="Полужирный" title="Полужирный" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M7.8 19c-.3 0-.5 0-.6-.2l-.2-.5V5.7c0-.2 0-.4.2-.5l.6-.2h5c1.5 0 2.7.3 3.5 1 .7.6 1.1 1.4 1.1 2.5a3 3 0 01-.6 1.9c-.4.6-1 1-1.6 1.2.4.1.9.3 1.3.6s.8.7 1 1.2c.4.4.5 1 .5 1.6 0 1.3-.4 2.3-1.3 3-.8.7-2.1 1-3.8 1H7.8zm5-8.3c.6 0 1.2-.1 1.6-.5.4-.3.6-.7.6-1.3 0-1.1-.8-1.7-2.3-1.7H9.3v3.5h3.4zm.5 6c.7 0 1.3-.1 1.7-.4.4-.4.6-.9.6-1.5s-.2-1-.7-1.4c-.4-.3-1-.4-2-.4H9.4v3.8h4z" fill-rule="evenodd"></path></svg></span></button><button aria-label="Курсив" title="Курсив" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M16.7 4.7l-.1.9h-.3c-.6 0-1 0-1.4.3-.3.3-.4.6-.5 1.1l-2.1 9.8v.6c0 .5.4.8 1.4.8h.2l-.2.8H8l.2-.8h.2c1.1 0 1.8-.5 2-1.5l2-9.8.1-.5c0-.6-.4-.8-1.4-.8h-.3l.2-.9h5.8z" fill-rule="evenodd"></path></svg></span></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><div aria-pressed="false" aria-label="Цвет текста" title="Цвет текста" role="button" aria-haspopup="true" unselectable="on" tabindex="-1" class="tox-split-button" aria-disabled="false" aria-expanded="false" aria-describedby="aria_2503511522111648452598896" style="user-select: none;"><span role="presentation" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><g fill-rule="evenodd"><path id="tox-icon-text-color__color" d="M3 18h18v3H3z"></path><path d="M8.7 16h-.8a.5.5 0 01-.5-.6l2.7-9c.1-.3.3-.4.5-.4h2.8c.2 0 .4.1.5.4l2.7 9a.5.5 0 01-.5.6h-.8a.5.5 0 01-.4-.4l-.7-2.2c0-.3-.3-.4-.5-.4h-3.4c-.2 0-.4.1-.5.4l-.7 2.2c0 .3-.2.4-.4.4zm2.6-7.6l-.6 2a.5.5 0 00.5.6h1.6a.5.5 0 00.5-.6l-.6-2c0-.3-.3-.4-.5-.4h-.4c-.2 0-.4.1-.5.4z"></path></g></svg></span></span><span role="presentation" tabindex="-1" class="tox-tbtn tox-split-button__chevron" aria-disabled="false"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></span><span aria-hidden="true" id="aria_2503511522111648452598896" style="display: none;">To open the popup, press Shift+Enter</span></div><div aria-pressed="false" aria-label="Цвет фона" title="Цвет фона" role="button" aria-haspopup="true" unselectable="on" tabindex="-1" class="tox-split-button" aria-disabled="false" aria-expanded="false" aria-describedby="aria_9736122392131648452598896" style="user-select: none;"><span role="presentation" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><g fill-rule="evenodd"><path id="tox-icon-highlight-bg-color__color" d="M3 18h18v3H3z"></path><path fill-rule="nonzero" d="M7.7 16.7H3l3.3-3.3-.7-.8L10.2 8l4 4.1-4 4.2c-.2.2-.6.2-.8 0l-.6-.7-1.1 1.1zm5-7.5L11 7.4l3-2.9a2 2 0 012.6 0L18 6c.7.7.7 2 0 2.7l-2.9 2.9-1.8-1.8-.5-.6"></path></g></svg></span></span><span role="presentation" tabindex="-1" class="tox-tbtn tox-split-button__chevron" aria-disabled="false"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></span><span aria-hidden="true" id="aria_9736122392131648452598896" style="display: none;">To open the popup, press Shift+Enter</span></div><button aria-label="Добавить смайл" title="Добавить смайл" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M9 11c.6 0 1-.4 1-1s-.4-1-1-1a1 1 0 00-1 1c0 .6.4 1 1 1zm6 0c.6 0 1-.4 1-1s-.4-1-1-1a1 1 0 00-1 1c0 .6.4 1 1 1zm-3 5.5c2.1 0 4-1.5 4.4-3.5H7.6c.5 2 2.3 3.5 4.4 3.5zM12 4a8 8 0 100 16 8 8 0 000-16zm0 14.5a6.5 6.5 0 110-13 6.5 6.5 0 010 13z" fill-rule="nonzero"></path></svg></span></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button aria-label="По левому краю" title="По левому краю" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M5 5h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 110-2zm0 4h8c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 110-2zm0 8h8c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 010-2zm0-4h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 010-2z" fill-rule="evenodd"></path></svg></span></button><button aria-label="По центру" title="По центру" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M5 5h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 110-2zm3 4h8c.6 0 1 .4 1 1s-.4 1-1 1H8a1 1 0 110-2zm0 8h8c.6 0 1 .4 1 1s-.4 1-1 1H8a1 1 0 010-2zm-3-4h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 010-2z" fill-rule="evenodd"></path></svg></span></button><button aria-label="По правому краю" title="По правому краю" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M5 5h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 110-2zm6 4h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0 8h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm-6-4h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 010-2z" fill-rule="evenodd"></path></svg></span></button><button aria-label="По ширине" title="По ширине" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M5 5h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 110-2zm0 4h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 110-2zm0 4h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 010-2zm0 4h14c.6 0 1 .4 1 1s-.4 1-1 1H5a1 1 0 010-2z" fill-rule="evenodd"></path></svg></span></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><div aria-pressed="false" aria-label="Маркированный список" title="Маркированный список" role="button" aria-haspopup="true" unselectable="on" tabindex="-1" class="tox-split-button" aria-disabled="false" aria-expanded="false" aria-describedby="aria_2999342352151648452598899" style="user-select: none;"><span role="presentation" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M11 5h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0 6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0 6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zM4.5 6c0-.4.1-.8.4-1 .3-.4.7-.5 1.1-.5.4 0 .8.1 1 .4.4.3.5.7.5 1.1 0 .4-.1.8-.4 1-.3.4-.7.5-1.1.5-.4 0-.8-.1-1-.4-.4-.3-.5-.7-.5-1.1zm0 6c0-.4.1-.8.4-1 .3-.4.7-.5 1.1-.5.4 0 .8.1 1 .4.4.3.5.7.5 1.1 0 .4-.1.8-.4 1-.3.4-.7.5-1.1.5-.4 0-.8-.1-1-.4-.4-.3-.5-.7-.5-1.1zm0 6c0-.4.1-.8.4-1 .3-.4.7-.5 1.1-.5.4 0 .8.1 1 .4.4.3.5.7.5 1.1 0 .4-.1.8-.4 1-.3.4-.7.5-1.1.5-.4 0-.8-.1-1-.4-.4-.3-.5-.7-.5-1.1z" fill-rule="evenodd"></path></svg></span></span><span role="presentation" tabindex="-1" class="tox-tbtn tox-split-button__chevron" aria-disabled="false"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></span><span aria-hidden="true" id="aria_2999342352151648452598899" style="display: none;">To open the popup, press Shift+Enter</span></div><div aria-pressed="false" aria-label="Нумерованный список" title="Нумерованный список" role="button" aria-haspopup="true" unselectable="on" tabindex="-1" class="tox-split-button" aria-disabled="false" aria-expanded="false" aria-describedby="aria_6975544702171648452598899" style="user-select: none;"><span role="presentation" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M10 17h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0-6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 010-2zm0-6h8c.6 0 1 .4 1 1s-.4 1-1 1h-8a1 1 0 110-2zM6 4v3.5c0 .3-.2.5-.5.5a.5.5 0 01-.5-.5V5h-.5a.5.5 0 010-1H6zm-1 8.8l.2.2h1.3c.3 0 .5.2.5.5s-.2.5-.5.5H4.9a1 1 0 01-.9-1V13c0-.4.3-.8.6-1l1.2-.4.2-.3a.2.2 0 00-.2-.2H4.5a.5.5 0 01-.5-.5c0-.3.2-.5.5-.5h1.6c.5 0 .9.4.9 1v.1c0 .4-.3.8-.6 1l-1.2.4-.2.3zM7 17v2c0 .6-.4 1-1 1H4.5a.5.5 0 010-1h1.2c.2 0 .3-.1.3-.3 0-.2-.1-.3-.3-.3H4.4a.4.4 0 110-.8h1.3c.2 0 .3-.1.3-.3 0-.2-.1-.3-.3-.3H4.5a.5.5 0 110-1H6c.6 0 1 .4 1 1z" fill-rule="evenodd"></path></svg></span></span><span role="presentation" tabindex="-1" class="tox-tbtn tox-split-button__chevron" aria-disabled="false"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></span><span aria-hidden="true" id="aria_6975544702171648452598899" style="display: none;">To open the popup, press Shift+Enter</span></div><button aria-label="Уменьшить отступ" title="Уменьшить отступ" type="button" tabindex="-1" class="tox-tbtn tox-tbtn--disabled" aria-disabled="true"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M7 5h12c.6 0 1 .4 1 1s-.4 1-1 1H7a1 1 0 110-2zm5 4h7c.6 0 1 .4 1 1s-.4 1-1 1h-7a1 1 0 010-2zm0 4h7c.6 0 1 .4 1 1s-.4 1-1 1h-7a1 1 0 010-2zm-5 4h12a1 1 0 010 2H7a1 1 0 010-2zm1.6-3.8a1 1 0 01-1.2 1.6l-3-2a1 1 0 010-1.6l3-2a1 1 0 011.2 1.6L6.8 12l1.8 1.2z" fill-rule="evenodd"></path></svg></span></button><button aria-label="Увеличить отступ" title="Увеличить отступ" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M7 5h12c.6 0 1 .4 1 1s-.4 1-1 1H7a1 1 0 110-2zm5 4h7c.6 0 1 .4 1 1s-.4 1-1 1h-7a1 1 0 010-2zm0 4h7c.6 0 1 .4 1 1s-.4 1-1 1h-7a1 1 0 010-2zm-5 4h12a1 1 0 010 2H7a1 1 0 010-2zm-2.6-3.8L6.2 12l-1.8-1.2a1 1 0 011.2-1.6l3 2a1 1 0 010 1.6l-3 2a1 1 0 11-1.2-1.6z" fill-rule="evenodd"></path></svg></span></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button aria-label="Вставить/редактировать ссылку" title="Вставить/редактировать ссылку" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M6.2 12.3a1 1 0 011.4 1.4l-2.1 2a2 2 0 102.7 2.8l4.8-4.8a1 1 0 000-1.4 1 1 0 111.4-1.3 2.9 2.9 0 010 4L9.6 20a3.9 3.9 0 01-5.5-5.5l2-2zm11.6-.6a1 1 0 01-1.4-1.4l2-2a2 2 0 10-2.6-2.8L11 10.3a1 1 0 000 1.4A1 1 0 119.6 13a2.9 2.9 0 010-4L14.4 4a3.9 3.9 0 015.5 5.5l-2 2z" fill-rule="nonzero"></path></svg></span></button><button aria-label="Вставить/редактировать изображение" title="Вставить/редактировать изображение" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M5 15.7l3.3-3.2c.3-.3.7-.3 1 0L12 15l4.1-4c.3-.4.8-.4 1 0l2 1.9V5H5v10.7zM5 18V19h3l2.8-2.9-2-2L5 17.9zm14-3l-2.5-2.4-6.4 6.5H19v-4zM4 3h16c.6 0 1 .4 1 1v16c0 .6-.4 1-1 1H4a1 1 0 01-1-1V4c0-.6.4-1 1-1zm6 8a2 2 0 100-4 2 2 0 000 4z" fill-rule="nonzero"></path></svg></span></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button title="Блоки" aria-label="Блоки" aria-haspopup="true" type="button" unselectable="on" tabindex="-1" class="tox-tbtn tox-tbtn--select tox-tbtn--bespoke" aria-expanded="false" style="user-select: none;"><span class="tox-tbtn__select-label">Параграф</span><div class="tox-tbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button><button title="Размер шрифта" aria-label="Размер шрифта" aria-haspopup="true" type="button" unselectable="on" tabindex="-1" class="tox-tbtn tox-tbtn--select tox-tbtn--bespoke" aria-expanded="false" style="user-select: none;"><span class="tox-tbtn__select-label">12pt</span><div class="tox-tbtn__select-chevron"><svg width="10" height="10"><path d="M8.7 2.2c.3-.3.8-.3 1 0 .4.4.4.9 0 1.2L5.7 7.8c-.3.3-.9.3-1.2 0L.2 3.4a.8.8 0 010-1.2c.3-.3.8-.3 1.1 0L5 6l3.7-3.8z" fill-rule="nonzero"></path></svg></div></button></div><div title="" role="toolbar" data-alloy-tabstop="true" tabindex="-1" class="tox-toolbar__group"><button aria-label="Исходный код" title="Исходный код" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><g fill-rule="nonzero"><path d="M9.8 15.7c.3.3.3.8 0 1-.3.4-.9.4-1.2 0l-4.4-4.1a.8.8 0 010-1.2l4.4-4.2c.3-.3.9-.3 1.2 0 .3.3.3.8 0 1.1L6 12l3.8 3.7zM14.2 15.7c-.3.3-.3.8 0 1 .4.4.9.4 1.2 0l4.4-4.1c.3-.3.3-.9 0-1.2l-4.4-4.2a.8.8 0 00-1.2 0c-.3.3-.3.8 0 1.1L18 12l-3.8 3.7z"></path></g></svg></span></button><button aria-label="Insert/edit media" title="Insert/edit media" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false" aria-pressed="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M4 3h16c.6 0 1 .4 1 1v16c0 .6-.4 1-1 1H4a1 1 0 01-1-1V4c0-.6.4-1 1-1zm1 2v14h14V5H5zm4.8 2.6l5.6 4a.5.5 0 010 .8l-5.6 4A.5.5 0 019 16V8a.5.5 0 01.8-.4z" fill-rule="nonzero"></path></svg></span></button><button aria-label="Добавить смайл" title="Добавить смайл" type="button" tabindex="-1" class="tox-tbtn" aria-disabled="false"><span class="tox-icon tox-tbtn__icon-wrap"><svg width="24" height="24"><path d="M9 11c.6 0 1-.4 1-1s-.4-1-1-1a1 1 0 00-1 1c0 .6.4 1 1 1zm6 0c.6 0 1-.4 1-1s-.4-1-1-1a1 1 0 00-1 1c0 .6.4 1 1 1zm-3 5.5c2.1 0 4-1.5 4.4-3.5H7.6c.5 2 2.3 3.5 4.4 3.5zM12 4a8 8 0 100 16 8 8 0 000-16zm0 14.5a6.5 6.5 0 110-13 6.5 6.5 0 010 13z" fill-rule="nonzero"></path></svg></span></button></div></div></div><div class="tox-anchorbar"></div></div><div class="tox-sidebar-wrap"><div class="tox-edit-area"><iframe id="mce_editor_0_ifr" frameborder="0" allowtransparency="true" title="Rich Text Area. Press ALT-0 for help." class="tox-edit-area__iframe"></iframe></div><div role="complementary" class="tox-sidebar"><div data-alloy-tabstop="true" tabindex="-1" class="tox-sidebar__slider tox-sidebar--sliding-closed" style="width: 0px;"><div class="tox-sidebar__pane-container"></div></div></div></div></div><div class="tox-statusbar"><div class="tox-statusbar__text-container"><div role="navigation" data-alloy-tabstop="true" class="tox-statusbar__path" aria-disabled="false"><div role="button" data-index="0" tab-index="-1" aria-level="1" tabindex="-1" class="tox-statusbar__path-item" aria-disabled="false">p</div></div><button type="button" data-alloy-tabstop="true" tabindex="-1" class="tox-statusbar__wordcount">1 words</button><span class="tox-statusbar__branding"><a href="https://www.tiny.cloud/?utm_campaign=editor_referral&amp;utm_medium=poweredby&amp;utm_source=tinymce&amp;utm_content=v5" rel="noopener" target="_blank" tabindex="-1" aria-label="Powered by Tiny">Powered by Tiny</a></span></div><div title="Resize" aria-hidden="true" class="tox-statusbar__resize-handle"><svg width="10" height="10"><g fill-rule="nonzero"><path d="M8.1 1.1A.5.5 0 119 2l-7 7A.5.5 0 111 8l7-7zM8.1 5.1A.5.5 0 119 6l-3 3A.5.5 0 115 8l3-3z"></path></g></svg></div></div><div aria-hidden="true" class="tox-throbber" style="display: none;"></div></div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <div class="vg-wrap vg-element vg-full">
        <div class="vg-wrap vg-element vg-full vg-firm-background-color4 vg-box-shadow">
            <div class="vg-element vg-half vg-left">
                <div class="vg-element vg-padding-in-px">
                    <input type="submit" class="vg-text vg-firm-color1 vg-firm-background-color4 vg-input vg-button" value="Сохранить">
                </div>
                <div class="vg-element vg-padding-in-px">
                    <a href="/admin/shop/delete/table/shop_products/id_row/id/id/92" class="vg-text vg-firm-color1 vg-firm-background-color4 vg-input vg-button vg-center vg_delete">
                        <span>Удалить</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
