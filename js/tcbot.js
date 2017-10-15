"use strict";

// Title and current mood display
var Title = React.createClass({
  displayName: "Title",

  render: function render() {
    var currentmood = this.props.currentmood;
    return React.createElement(
      "div",
      null,
      React.createElement(
        "h1",
        null,
        "How's your mood today?"
      ),
      React.createElement(
        "h3",
        null,
        "Current Mood: ",
        currentmood
      )
    );
  }
});

// Choosing your mood
var MoodCard = React.createClass({
  displayName: "MoodCard",

  setMood: function setMood(mood) {
    this.props.handleMood(mood);
  },
  render: function render() {
    return React.createElement(
      "div",
      { className: "card" },
      React.createElement(
        "ul",
        { className: "mood-list" },
        this.props.mood.map(function (mood) {
          var _this = this;

          return React.createElement(
            "li",
            { key: mood.key, className: "mood-item", onClick: function onClick() {
                _this.setMood(mood.mood);
              } },
            mood.mood
          );
        }, this)
      )
    );
  }
});

// Logic playground based on mood selection
var Greeting = React.createClass({
  displayName: "Greeting",
  renderMessage: function renderMessage() {
    if (this.props.mood == 'Excited') {
      return React.createElement(
        "div",
        null,
        "Glad to know! What makes you feel ",
        this.props.mood,
        "?"
      );
    } else if (this.props.mood == 'Happy') {
      return React.createElement(
        "div",
        null,
        "That sounds great. What makes you feel ",
        this.props.mood,
        "?"
      );
    } else if (this.props.mood == 'Netural') {
      return React.createElement(
        "div",
        null,
        "What's happening today?"
      );
    } else if (this.props.mood == 'Sad' || this.props.mood == 'Angry') {
      return React.createElement(
        "div",
        null,
        "Sorry to hear that. What causes you ",
        this.props.mood,
        "?"
      );
    } else {
      return React.createElement(
        "div",
        null,
        "Please select a mood"
      );
    }
  },

  render: function render() {
    return React.createElement(
      "div",
      null,
      React.createElement(
        "h3",
        null,
        "Yes / No logic, is current mood = happy? "
      ),
      React.createElement(
        "div",
        { className: "box" },
        this.props.mood == 'Happy' ? 'Yes! ^_^' : 'No :('
      ),
      React.createElement(
        "h3",
        null,
        "Conditional display based on current mood"
      ),
      React.createElement(
        "div",
        { className: "box" },
        this.renderMessage()
      )
    );
  }
});

// Putting everything together
var App = React.createClass({
  displayName: "App",

  getInitialState: function getInitialState() {
    return {
      mood: [{ key: 1, mood: 'Excited' }, { key: 2, mood: 'Happy' }, { key: 3, mood: 'Netural' }, { key: 4, mood: 'Sad' }, { key: 5, mood: 'Angry' }],
      currentmood: 'N/A'
    };
  },
  setMood: function setMood(newMood) {
    this.setState({ currentmood: newMood });
  },
  render: function render() {
    return React.createElement(
      "div",
      null,
      React.createElement(Title, { currentmood: this.state.currentmood }),
      React.createElement(MoodCard, { handleMood: this.setMood, mood: this.state.mood }),
      React.createElement("hr", null),
      React.createElement(Greeting, { mood: this.state.currentmood })
    );
  }
});

// Render to DOM
var destination = document.querySelector(".tcbot-body");
ReactDOM.render(React.createElement(App, null), destination);
//# sourceURL=pen.js
