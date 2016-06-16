import React from 'react';
import {render} from 'react-dom';

var CommentsRow = React.createClass({
    render: function() {
        return (
            <div>
                {this.props.item.name}
                {this.props.item.comment}
                {this.props.item.timestamp}
            </div>
        )
    }
});

var CommentsList = React.createClass({
    getInitialState: function() {
        return {
            items: []
      }
    },
    componentWillMount: function() {
        $.get(this.props.dataUrl, function(data){
            if(this.isMounted()) {
                this.setState({
                    items: data
                });
            }
        }.bind(this));
    },
    render: function () {
        var rows = [];
        console.log(this.state.items); // Results in empty array
        this.state.items.forEach(function(item){
            rows.push(<CommentsRow key={item.user_id} item={item} />)
        });
        return (
            console.log(rows) // Results in empty array
        );
    }
});
ReactDOM.render(<CommentsList dataUrl="/project/server.php/dashboard/communities" />, document.getElementById('viewComment'));
// Figure out how to pass data into React