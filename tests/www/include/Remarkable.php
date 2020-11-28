<?php
use PHPMV\react\ReactJS;

echo '<script src=" https://unpkg.com/babel-standalone@6/babel.min.js"></script>';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/remarkable/1.7.1/remarkable.js"></script>';
$react = new ReactJS();
$compo = $react->createComponent('MarkdownEditor');
$compo->addConstructor("this.md = new Remarkable();
    this.handleChange = this.handleChange.bind(this);
    this.state = { value: 'Bonjour, **monde** !' };");
$compo->addMethod('handleChange', "this.setState({ value: e.target.value });", 'e');
$compo->addMethod('getRawMarkup', "return { __html: this.md.render(this.state.value) };");
$compo->addRender('<div className="MarkdownEditor">
        <h3>Entrée</h3>
        <label htmlFor="markdown-content">
          Saisissez du markdown
        </label>
        <textarea
          id="markdown-content"
          onChange="{this.handleChange}"
          defaultValue="{this.state.value}"
        />
        <h3>Sortie</h3>
        <div
          className="content"
          dangerouslySetInnerHTML="{this.getRawMarkup()}"
        />
      </div>');
$react->renderComponent('<MarkdownEditor />', '#react');

echo $react->compile();