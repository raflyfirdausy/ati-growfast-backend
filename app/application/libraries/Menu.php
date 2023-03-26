<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu
{
    private $CI;
    private $ROLE;

    public function __construct($params = [])
    {
        $this->CI   = &get_instance();
        $this->ROLE = $params["role"];
    }

    public function generateChild($parent)
    {
        $data = ["menuList"  => $parent];
        $this->CI->load->view("template/sidebar/sidebar_child", $data);
    }

    public function generate()
    {
        $resultMenuList = $this->getChild($this->_getMenuList());
        for ($i = 0; $i < sizeof($resultMenuList); $i++) {
            if (empty($resultMenuList[$i]["child"])) {
                unset($resultMenuList[$i]);
            }
        }

        $data = [
            "menuList"  => $resultMenuList
        ];
        return $this->CI->load->view("template/sidebar/sidebar_base", $data);
    }

    private function getChild($menuList)
    {
        $resultMenuList    = [];
        foreach ($menuList as $mList) {
            if (isset($mList["roles"])) {
                if (in_array("*", $mList["roles"]) || in_array($this->ROLE, $mList["roles"])) {
                    $child = [];
                    if (isset($mList["child"]) && !empty($mList["child"])) {
                        $child = $mList["child"];
                        unset($mList["child"]);
                        $mList["child"] = $this->getChild($child);
                    }
                    array_push($resultMenuList, $mList);
                }
            }
        }
        return $resultMenuList;
    }

    private function _menuberandaList()
    {
        return [
            "title"         => "Beranda",
            "roles"         => ["*"],
            "child"         => [
                [
                    "title"     => "Beranda SIMKLINIK",
                    "path"      => "/dashboard",
                    "icon"      => "mdi mdi-code-equal",
                    "roles"     => ["*"],
                    "child"     => []
                ],
            ],
        ];
    }

    private function _menuMasterList()
    {
        return [
            "title"         => "Master Data",
            "roles"         => ["*"],
            "child"         => [
                [
                    "title"     => "Alat & Barang",
                    "path"      => "/master/alat-barang",
                    "icon"      => "mdi mdi-code-equal",
                    "roles"     => ["*"],
                    "child"     => []
                ],
                [
                    "title"     => "Instansi",
                    "path"      => "/master/instansi",
                    "icon"      => "mdi mdi-code-equal",
                    "roles"     => ["*"],
                    "child"     => []
                ],
                [
                    "title"     => "Pengguna",
                    "path"      => "#",
                    "icon"      => "mdi mdi-code-equal",
                    "roles"     => ["*"],
                    "child"     => [
                        [
                            "title"     => "Admin",
                            "path"      => "/master/user/admin",
                            "icon"      => "mdi mdi-code-equal",
                            "roles"     => [],
                            "child"     => []
                        ],
                        [
                            "title"     => "Petugas",
                            "path"      => "/master/user/petugas",
                            "icon"      => "mdi mdi-code-equal",
                            "roles"     => ["*"],
                            "child"     => []
                        ],
                        [
                            "title"     => "Instansi",
                            "path"      => "/master/user/instansi",
                            "icon"      => "mdi mdi-code-equal",
                            "roles"     => ["*"],
                            "child"     => []
                        ],
                    ]
                ],
            ],
        ];
    }

    private function _menuTransaksiList()
    {
        return [
            "title"         => "Transaksi",
            "roles"         => ["*"],
            "child"         => [
                [
                    "title"     => "Penawaran Jasa",
                    "path"      => "/transaksi/penawaran",
                    "icon"      => "mdi mdi-code-equal",
                    "roles"     => ["*"],
                    "child"     => []
                ],
                [
                    "title"     => "Penugasan",
                    "path"      => "/transaksi/penugasan",
                    "icon"      => "mdi mdi-code-equal",
                    "roles"     => ["*"],
                    "child"     => []
                ],
            ]
        ];
    }

    private function _menuLaporanList()
    {
        return [
            "title"         => "Laporan",
            "roles"         => ["*"],
            "child"         => []
        ];
    }

    private function _getMenuList()
    {
        $listMenuPush       = [
            $this->_menuberandaList(),
            $this->_menuMasterList(),
            $this->_menuTransaksiList(),
            $this->_menuLaporanList(),
        ];

        $resultMenuDrawer   = [];
        foreach ($listMenuPush as $list) {
            array_push($resultMenuDrawer, $list);
        }
        return $resultMenuDrawer;
    }
}
