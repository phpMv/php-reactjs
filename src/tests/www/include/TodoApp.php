<?php
use PHPMV\react\ReactJS;

$react = new ReactJS();
$compo = $react->createComponent('TodoList');
$compo->addRender("<ul>
        {this.props.items.map(item => (
          <li key={item.id}>{item.text}</li>
        ))}
      </ul>");

$compo = $react->createComponent('TodoApp');

$compo->addConstructor("this.state = { items: [], text: '' };
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);");
$compo->addRender('<div>
        <h3>À faire</h3>
        <TodoList items="{this.state.items}" />
        <form onSubmit="{this.handleSubmit}">
          <label htmlFor="new-todo">
            Que faut-il faire ?
          </label>
          <input
            id="new-todo"
            onChange="{this.handleChange}"
            value="{this.state.text}"
          />
          <button id="btAdd">
            Ajouter #{this.state.items.length + 1}
          </button>
        </form>
      </div>');

$compo->addMethod('handleChange', 'this.setState({ text: e.target.value });', 'e');
$compo->addMethod('handleSubmit', 'e.preventDefault();
    if (this.state.text.length === 0) {
      return;
    }
    const newItem = {
      text: this.state.text,
      id: Date.now()
    };
    this.setState(state => ({
      items: state.items.concat(newItem),
      text: ""
    }));', 'e');
$react->renderComponent('<TodoApp />', '#react');

echo $react->compile();