import('../../css/admin/naviquiz.css');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import 'jquery.fancytree/dist/skin-lion/ui.fancytree.less';  // CSS or LESS

const $ = require('jquery');
import 'jquery-ui';
import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';
import 'jquery.fancytree/dist/modules/jquery.fancytree.dnd';

import {createTree} from 'jquery.fancytree';

const tree = createTree('#tree', {
    extensions: ['edit', 'filter', 'dnd'],
    source: $.ajax({
        url: "/api/tree/naviquiz",
        dataType: "json",
        cache: false
    }),
    dnd: {
        autoExpandMS: 400,
        draggable: { // modify default jQuery draggable options
            zIndex: 1000,
            scroll: false,
            revert: "invalid"
        },
        preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.

        dragStart: function(node, data) {

            // This function MUST be defined to enable dragging for the tree.
            // Return false to cancel dragging of node.
//    if( data.originalEvent.shiftKey ) ...
//    if( node.isFolder() ) { return false; }
            return true;
        },
        dragEnter: function(node, data) {

            return true;
        },
        dragExpand: function(node, data) {
            // return false to prevent auto-expanding data.node on hover
        },
        dragOver: function(node, data) {
            if(data.otherNode.data.hasOwnProperty('id_parent_question') && node.data.hasOwnProperty('id_parent_reponse') ||
                data.otherNode.data.hasOwnProperty('id_parent_reponse') && node.data.hasOwnProperty('id_parent_question')) {
                return true

            }
            /* data.otherNode may be null for non-fancytree droppables.
             * Return false to disallow dropping on node. In this case
             * dragOver and dragLeave are not called.
             * Return 'over', 'before, or 'after' to force a hitMode.
             * Return ['before', 'after'] to restrict available hitModes.
             * Any other return value will calc the hitMode from the cursor position.
             */
            // Prevent dropping a parent below another parent (only sort
            // nodes under the same parent):
//    if(node.parent !== data.otherNode.parent){
//      return false;
//    }
            // Don't allow dropping *over* a node (would create a child). Just
            // allow changing the order:
//    return ["before", "after"];
            // Accept everything:
            return false;
        },
        dragLeave: function(node, data) {
        },
        dragStop: function(node, data) {
        },
        dragDrop: function(node, data) {
            if(data.otherNode.data.hasOwnProperty('id_parent_question') && node.data.hasOwnProperty('id_parent_reponse') ||
                data.otherNode.data.hasOwnProperty('id_parent_reponse') && node.data.hasOwnProperty('id_parent_question')) {
                data.otherNode.moveTo(node, data.hitMode);
                let d = tree.toDict(true);
                alert(JSON.stringify(d));
            }




            // This function MUST be defined to enable dropping of items on the tree.
            // data.hitMode is 'before', 'after', or 'over'.
            // We could for example move the source to the new target:
        }
    }

});

const tree_reponse = createTree('#tree-reponses', {
    extensions: ['edit', 'filter', 'dnd'],
    source: $.ajax({
        url: "/api/tree/reponse/ophelins",
        dataType: "json",
        cache: false
    }),
    dnd: {
        autoExpandMS: 400,
        draggable: { // modify default jQuery draggable options
            zIndex: 1000,
            scroll: false,
            revert: "invalid"
        },
        preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.

        dragStart: function(node, data) {
            // This function MUST be defined to enable dragging for the tree.
            // Return false to cancel dragging of node.
//    if( data.originalEvent.shiftKey ) ...
//    if( node.isFolder() ) { return false; }
            return true;
        },
        dragEnter: function(node, data) {
            /* data.otherNode may be null for non-fancytree droppables.
             * Return false to disallow dropping on node. In this case
             * dragOver and dragLeave are not called.
             * Return 'over', 'before, or 'after' to force a hitMode.
             * Return ['before', 'after'] to restrict available hitModes.
             * Any other return value will calc the hitMode from the cursor position.
             */
            // Prevent dropping a parent below another parent (only sort
            // nodes under the same parent):
//    if(node.parent !== data.otherNode.parent){
//      return false;
//    }
            // Don't allow dropping *over* a node (would create a child). Just
            // allow changing the order:
//    return ["before", "after"];
            // Accept everything:
            return true;
        },
        dragExpand: function(node, data) {
            // return false to prevent auto-expanding data.node on hover
        },
        dragOver: function(node, data) {
        },
        dragLeave: function(node, data) {
        },
        dragStop: function(node, data) {
        },
        dragDrop: function(node, data) {
            data.otherNode.moveTo(node, data.hitMode);
            // This function MUST be defined to enable dropping of items on the tree.
            // data.hitMode is 'before', 'after', or 'over'.
            // We could for example move the source to the new target:
        }
    }

});

const tree_question = createTree('#tree-questions', {
    extensions: ['edit', 'filter', 'dnd'],
    source: $.ajax({
        url: "/api/tree/question/ophelins",
        dataType: "json",
        cache: false
    }),
    dnd: {
        autoExpandMS: 400,
        draggable: { // modify default jQuery draggable options
            zIndex: 1000,
            scroll: false,
            /*containment: "parent",*/ // Empèche de sortir du cadre du #tree
            revert: "invalid"
        },
        preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.

        dragStart: function(node, data) {
            // This function MUST be defined to enable dragging for the tree.
            // Return false to cancel dragging of node.
//    if( data.originalEvent.shiftKey ) ...
//    if( node.isFolder() ) { return false; }
            return true;
        },
        dragEnter: function(node, data) {
            /* data.otherNode may be null for non-fancytree droppables.
             * Return false to disallow dropping on node. In this case
             * dragOver and dragLeave are not called.
             * Return 'over', 'before, or 'after' to force a hitMode.
             * Return ['before', 'after'] to restrict available hitModes.
             * Any other return value will calc the hitMode from the cursor position.
             */
            // Prevent dropping a parent below another parent (only sort
            // nodes under the same parent):
//    if(node.parent !== data.otherNode.parent){
//      return false;
//    }
            // Don't allow dropping *over* a node (would create a child). Just
            // allow changing the order:
//    return ["before", "after"];
            // Accept everything:
            return true;
        },
        dragExpand: function(node, data) {
            // return false to prevent auto-expanding data.node on hover
        },
        dragOver: function(node, data) {
            let check = data;
            console.log(check);
        },
        dragLeave: function(node, data) {
        },
        dragStop: function(node, data) {
        },
        dragDrop: function(node, data) {
            data.otherNode.moveTo(node, data.hitMode);
        }
    },
    postProcess: function(event, data){
        data.result = convertData(data.response);
    }

});

const tree_corbeille = createTree('#tree-corbeille', {
    extensions: ['edit', 'filter', 'dnd'],
    source: [{title: "Corbeille", key: "9999999", icon: "fas fa-trash-alt"}],
    dnd: {
        autoExpandMS: 400,
        draggable: { // modify default jQuery draggable options
            zIndex: 1000,
            scroll: false,
            revert: "invalid"
        },
        preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.

        dragStart: function(node, data) {
            // This function MUST be defined to enable dragging for the tree.
            // Return false to cancel dragging of node.
//    if( data.originalEvent.shiftKey ) ...
//    if( node.isFolder() ) { return false; }
            return true;
        },
        dragEnter: function(node, data) {
            /* data.otherNode may be null for non-fancytree droppables.
             * Return false to disallow dropping on node. In this case
             * dragOver and dragLeave are not called.
             * Return 'over', 'before, or 'after' to force a hitMode.
             * Return ['before', 'after'] to restrict available hitModes.
             * Any other return value will calc the hitMode from the cursor position.
             */
            // Prevent dropping a parent below another parent (only sort
            // nodes under the same parent):
//    if(node.parent !== data.otherNode.parent){
//      return false;
//    }
            // Don't allow dropping *over* a node (would create a child). Just
            // allow changing the order:
//    return ["before", "after"];
            // Accept everything:
            return true;
        },
        dragExpand: function(node, data) {
            // return false to prevent auto-expanding data.node on hover
        },
        dragOver: function(node, data) {
        },
        dragLeave: function(node, data) {
        },
        dragStop: function(node, data) {
        },
        dragDrop: function(node, data) {
            data.otherNode.moveTo(node, data.hitMode);
            // This function MUST be defined to enable dropping of items on the tree.
            // data.hitMode is 'before', 'after', or 'over'.
            // We could for example move the source to the new target:
        }
    }

});

function convertData(childList) {
    var parent,
        nodeMap = {};

    if( childList.kind === "tasks#tasks" ) {
        childList = childList.items;
    }
    // Pass 1: store all tasks in reference map
    $.each(childList, function(i, c){
        nodeMap[c.id] = c;
    });
    // Pass 2: adjust fields and fix child structure
    childList = $.map(childList, function(c){
        // Rename 'key' to 'id'
        c.key = c.id;
        delete c.id;
        // Set checkbox for completed tasks
        c.selected = (c.status === "completed");
        // Check if c is a child node
        if( c.parent ) {
            // add c to `children` array of parent node
            parent = nodeMap[c.parent];
            if( parent.children ) {
                parent.children.push(c);
            } else {
                parent.children = [c];
            }
            return null;  // Remove c from childList
        }
        return c;  // Keep top-level nodes
    });
    // Pass 3: sort children by 'position'
    $.each(childList, function(i, c){
        if( c.children && c.children.length > 1 ) {
            c.children.sort(function(a, b){
                return ((a.position < b.position) ? -1 : ((a.position > b.position) ? 1 : 0));
            });
        }
    });
    return childList;
}