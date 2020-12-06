<?php
use PHPMV\react\ReactJS;
$react = new ReactJS();
$compo = $react->createComponent('HelloMessage');
$compo->addRender("<div>Salut {this.props.name}</div>");
$react->renderComponent('<HelloMessage name="Thierry" />', '#react');

echo $react->__toString();