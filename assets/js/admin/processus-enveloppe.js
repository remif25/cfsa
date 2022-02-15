import('../../css/admin/processus-enveloppe.scss');
import('babel-polyfill');

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

import 'jquery.fancytree/dist/skin-lion/ui.fancytree.less';  // CSS or LESS

const $ = require('jquery');
import 'jquery-ui';
import 'jquery.fancytree/dist/modules/jquery.fancytree.edit';
import 'jquery.fancytree/dist/modules/jquery.fancytree.filter';
import 'jquery.fancytree/dist/modules/jquery.fancytree.dnd';

import {createTree} from 'jquery.fancytree';

const tree_pe = createTree('#processus-enveloppe', {
    extensions: ['edit', 'filter', 'dnd'],
    filter: {nodata: false, mode: 'hide'},
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
            if(data.otherNode.data.hasOwnProperty('id_parent_question') && node.data.hasOwnProperty('id_parent_reponse') && data.hitMode === "over" ||
                data.otherNode.data.hasOwnProperty('id_parent_reponse') && node.data.hasOwnProperty('id_parent_question') && data.hitMode === "over") {
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
            if(data.otherNode.data.hasOwnProperty('id_parent_question') && node.data.hasOwnProperty('id_parent_reponse') && data.hitMode === "over" ||
                data.otherNode.data.hasOwnProperty('id_parent_reponse') && node.data.hasOwnProperty('id_parent_question') && data.hitMode === "over") {
                data.otherNode.moveTo(node, data.hitMode);
                sendtree();
            }

            // This function MUST be defined to enable dropping of items on the tree.
            // data.hitMode is 'before', 'after', or 'over'.
            // We could for example move the source to the new target:
        }
    }

});

const tree_ge = createTree('#gamme-enveloppes', {
    extensions: ['edit', 'filter', 'dnd'],
    filter: {nodata: false, mode: 'hide'},
    source: $.ajax({
        url: "/api/tree/gammesEnveloppes",
        dataType: "json",
        cache: false
    }),
    dnd: {
        autoExpandMS: 400,
        draggable: { // modify default jQuery draggable options
            zIndex: 1000,
            scroll: false,
            containment: "parent",
        },
        preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
        preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.

        dragStart: function(node, data) {
            // This function MUST be defined to enable dragging for the tree.
            // Return false to cancel dragging of node.
//    if( data.originalEvent.shiftKey ) ...
//    if( node.isFolder() ) { return false; }
            if (node.key === "9999999") {
                return false;
            }

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
            return true;
//    }
            // Don't allow dropping *over* a node (would create a child). Just
            // allow changing the order:
//    return ["before", "after"];
            // Accept everything:

        },
        dragExpand: function(node, data) {
            // return false to prevent auto-expanding data.node on hover
        },
        dragOver: function(node, data) {
            if (data.hitMode === 'over') {
                return true;

            }

            return false;
        },
        dragLeave: function(node, data) {
        },
        dragStop: function(node, data) {
        },
        dragDrop: function(node, data) {
            if (data.hitMode === 'over') {
                data.otherNode.moveTo(node, data.hitMode);
                removeParent();
            }
            // This function MUST be defined to enable dropping of items on the tree.
            // data.hitMode is 'before', 'after', or 'over'.
            // We could for example move the source to the new target:
        }
    }
});

$('#ge-filter').keyup(function () {
    tree_ge.filterNodes($(this).val());
})
