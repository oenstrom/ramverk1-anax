<?php

namespace Anax\App;

/**
 * An App class to wrap the resources of the framework.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class App
{
    public function redirect($url)
    {
        $this->response->redirect($this->url->create($url));
        exit;
    }



    /**
     * Render a standard web page using a specific layout.
     */
    public function renderPage($data, $status = 200)
    {
        $data["stylesheets"] = ["css/style.min.css"];
        $navbar = $this->navbar->createNavbar();

        if (array_key_exists("views", $data)) {
            foreach ($data["views"] as $value) {
                $this->view->add($value[0], $value[1]);
            }
        }

        // Add common header, navbar and footer
        $this->view->add("default1/header", [], "header");
        $this->view->add("default1/navbar", ["navbar" => $navbar], "header");
        $this->view->add("default1/footer", [], "footer");

        // Add layout, render it, add to response and send.
        $this->view->add("default1/layout", $data, "layout");
        $body = $this->view->renderBuffered("layout");
        $this->response->setBody($body)
                       ->send($status);
        exit;
    }
}
