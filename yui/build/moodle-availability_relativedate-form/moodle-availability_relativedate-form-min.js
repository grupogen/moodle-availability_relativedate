YUI.add("moodle-availability_relativedate-form",function(o,e){M.availability_relativedate=M.availability_relativedate||{},M.availability_relativedate.form=o.Object(M.core_availability.plugin),M.availability_relativedate.form.timeFields=null,M.availability_relativedate.form.startFields=null,M.availability_relativedate.form.isSection=null,M.availability_relativedate.form.warningStrings=null,M.availability_relativedate.form.initInner=function(e,t,a,i,l){this.timeFields=e,this.startFields=t,this.isSection=a,this.warningStrings=i,this.activitySelector=l},M.availability_relativedate.form.getNode=function(e){for(var t,a,i,l,n='<span class="availability-relativedate">',r=0,s=0,r=0;r<this.warningStrings.length;r++)n+='<div class="alert alert-warning alert-block fade in " role="alert">'+this.warningStrings[r]+"</div>";for(n+='<label><select name="relativenumber">',r=1;r<60;r++)n+='<option value="'+r+'">'+r+"</option>";for(n=n+"</select></label> "+'<label><select name="relativednw">',r=0;r<this.timeFields.length;r++)n+='<option value="'+(t=this.timeFields[r]).field+'">'+t.display+"</option>";for(n=n+"</select></label> "+'<label><select name="relativestart">',r=0;r<this.startFields.length;r++)n+='<option value="'+(t=this.startFields[r]).field+'">'+t.display+"</option>";for(n=n+"</select></label>"+('<label><select name="relativecoursemodule"'+(7!=e.s?' style="display: none;"':"")+">"),r=a=0;r<this.activitySelector.length;r++)for(n+="<option disabled>"+this.activitySelector[r].name+"</option>",s=0;s<this.activitySelector[r].coursemodules.length;s++)n+='<option value="'+this.activitySelector[r].coursemodules[s].id+'"',0==this.activitySelector[r].coursemodules[s].completionenabled?n+=" disabled":a=a||this.activitySelector[r].coursemodules[s].id,n+=">"+this.activitySelector[r].coursemodules[s].name+"</option>";return i=o.Node.create("<span>"+(n+="</select></label>")+"</span>"),r=1,e.n!==undefined&&(r=e.n),i.one("select[name=relativenumber]").set("value",r),r=2,e.d!==undefined&&(r=e.d),i.one("select[name=relativednw]").set("value",r),r=1,e.s!==undefined&&(r=e.s),i.one("select[name=relativestart]").set("value",r),r=a,e.m!==undefined&&(r=e.m),i.one("select[name=relativecoursemodule]").set("value",r),M.availability_relativedate.form.addedEvents||(M.availability_relativedate.form.addedEvents=!0,e=o.one(".availability-field"),l=function(e){var e=e.ancestor("span.availability_relativedate"),t=e.one("select[name=relativestart]");"7"==t.get("value")?e.one("select[name=relativecoursemodule]").set("style",""):e.one("select[name=relativecoursemodule]").set("style","display: none;"),M.core_availability.form.update()},e.delegate("change",function(){l(this)},".availability_relativedate select")),i},M.availability_relativedate.form.fillValue=function(e,t){e.n=Number(t.one("select[name=relativenumber]").get("value")),e.d=Number(t.one("select[name=relativednw]").get("value")),e.s=Number(t.one("select[name=relativestart]").get("value")),e.m=0,7==e.s&&(e.m=Number(t.one("select[name=relativecoursemodule]").get("value")))},M.availability_relativedate.form.fillErrors=function(e,t){this.fillValue({},t)}},"@VERSION@",{requires:["base","node","event","moodle-core_availability-form"]});