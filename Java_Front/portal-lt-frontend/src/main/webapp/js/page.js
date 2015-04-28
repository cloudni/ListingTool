/**
 * 实例化该对象时必须传入一个form的jquery对象
 * 
 * @param formObj
 */
function PageBean(formObj) {

	if (formObj == null) {
		throw new Error("No form object!");
	} else {
		formObj.find("input:hidden[name='pageNo").val(1);
	}

	this.myform = formObj;

	this.callback;

	this.tableId;

	this.footId;

	PageBean.prototype.setFootId = function(fid) {
		this.footId = fid;
	};

	PageBean.prototype.getFootId = function() {
		return this.footId;
	};

	PageBean.prototype.setTableId = function(tbId) {
		this.tableId = tbId;
	};

	PageBean.prototype.setCallback = function(cb) {
		this.callback = cb;
	};

	PageBean.prototype.getCallback = function() {
		return this.callback;
	};

	PageBean.prototype.getTableId = function() {
		return this.tableId;
	};

	PageBean.prototype.getForm = function() {
		return this.myform;
	};

	PageBean.prototype.getFormId = function() {
		return this.myform.attr("id");
	};

	PageBean.prototype.doPage = function() {
		if (this.getCallback() == null) {
			throw new Error("No callback function!");
		}
		var _myform = this.getForm();
		var url = _myform.attr("action");
		var data = _myform.serialize();
		var mytb = this.getTableId();
		var _footId = this.getFootId();
		var _callback = this.getCallback();
		data += "&tableId=" + mytb + this.getFormId();
		$.ajax({
			url : url,
			type : "post",
			dataType : "json",
			data : data,
			async : true,
			success : function(Data) {
				$("#" + mytb).find("tr:not(:first)").remove();
				var pagenoo = _myform.find("input[name='pageNo']");
				pagenoo.val(Data.pageNo);
				var result = Data.results;
				var ft = getFooterHTML(Data);
				$("#" + _footId).html(ft);
				var pageParam = {};
				pageParam.pageNo = Data.pageNo;
				pageParam.pageSize = Data.pageSize;
				pageParam.totalRecord = Data.totalRecord;
				pageParam.totalPage = Data.totalPage;
				_callback(result, pageParam);
				/* eval(callback + "(result,ft)"); */
			},
			error : function(a, b, c) {
				alert("分页查询异常:" + b);
			}
		});
	};
}

var pagebeanArray = [];

/**
 * 全局化pagebean对象
 * 
 * @param pgo
 */
function setPagebeanObj(pgo) {
	var tbId = pgo.getTableId() + pgo.getFormId();
	var o = {
		id : tbId,
		obj : pgo
	};
	pagebeanArray.push(o);
}

/**
 * 根据tableId获取pageBean对象
 * 
 * @param
 * @returns
 */
function getPagebeaObj(tbId) {
	var o = null;
	$.each(pagebeanArray, function(ind, po) {
		if (po != null) {
			if (po.id == tbId) {
				o = po.obj;
				return false;
			}
		}
	});
	return o;
}

function setPageNo(pageno, tableId) {
	var pagebean = getPagebeaObj(tableId);
	var form = pagebean.getForm();
	form.find("input[name='pageNo']").val(pageno);
	pagebean.doPage();
}

function goPage(no, tbId) {
	var v = $("#tzd_" + tbId).val();
	if (isNaN(v)) {
		alert("输入页数不合法!");
		return;
	}
	if (parseInt(v) > no) {
		alert("输入页数超大!");
		return;
	}
	setPageNo(v, tbId);
}

/*
 * <span>第3/2000页</span> <span>首页</span> <span>上一页</span> <span><a
 * href="#">下一页</a></span> <span><a href="#">末页</a></span> <span>跳转到<input
 * type="text" class="black_text mlr5">页 </span> <span class="page_go"><a
 * href="#">go</a></span>
 * 
 */
function getFooterHTML(pageBean) {
	// 当前页和总页数
	var footer = "<span>第" + pageBean.pageNo + "/" + pageBean.totalPage
			+ "页</span>";

	// 上一页和首页
	if (pageBean.pageNo > 1) { // 如果不是第一页
		var prexNo = pageBean.pageNo - 1;
		footer += "<span style=\"cursor: pointer;\" onclick=\"setPageNo(1,'"
				+ pageBean.tableId + "')\"><a>首页</a></span>";
		footer += "<span  style=\"cursor: pointer;\" onclick=\"setPageNo("
				+ prexNo + ",'" + pageBean.tableId + "')\"><a>上一页</a></span>";
	} else if (pageBean.pageNo == 1) { // 当前如果是第一页
		footer += "<span>首页</span>";
		footer += "<span>上一页</span>";
	}

	if (pageBean.pageNo < pageBean.totalPage) { // 当前如果不是最后一页
		var nextNo = pageBean.pageNo + 1;
		footer += "<span style=\"cursor: pointer;\"  onclick=\"setPageNo("
				+ nextNo + ",'" + pageBean.tableId + "')\"><a>下一页</a></span>";
		footer += "<span style=\"cursor: pointer;\" onclick=\"setPageNo("
				+ pageBean.totalPage + ",'" + pageBean.tableId
				+ "')\"><a>末页</a></span>";
	} else { // 如果是最后一页
		footer += "<span>下一页</span>";
		footer += "<span>末页</span>";
	}

	footer += "<span >跳转到<input type=\"text\" class=\"black_text mlr5\" id=\"tzd_"
			+ pageBean.tableId + "\">页</span>";
	footer += " <span class=\"page_go\"><a href=\"javascript:goPage("
			+ pageBean.totalPage + ",'" + pageBean.tableId
			+ "');\">go</a></span>";
	return footer;
}