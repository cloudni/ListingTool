<div class="summary" align="right">Displaying ${(page.pageNo-1)*page.pageSize+1 }-${(page.pageNo*page.pageSize)>page.totalRecord?page.totalRecord:(page.pageNo*page.pageSize) } of ${page.totalRecord } results.</div>
<div class="pager">Go to page: <ul id="yw1" class="yiiPager">
<!-- <li class="first"><a href="${phpPath }/department/index">&lt;&lt; First</a></li> -->
<li class="previous"><a href="${ctxPath}/${page.requestPath }.shtml?pageNo=${page.pageNo-1>0?page.pageNo-1:1 }">&lt; Previous</a></li>
<c:if test="${page.totalPage>0 && page.totalPage<=15 }">
<c:forEach begin="1" end="${page.totalPage }" varStatus="step">
	<li class="${step.count==page.pageNo?'page selected':'page' }"><a href="${ctxPath}/${page.requestPath }.shtml?pageNo=${step.count }">${step.count }</a></li>
</c:forEach>
</c:if>
<li class="next"><a href="${ctxPath}/${page.requestPath }.shtml?pageNo=${page.pageNo+1>page.totalPage?page.pageNo:page.pageNo+1 }">Next &gt;</a></li>
<!-- <li class="last"><a href="${phpPath }/department/index?Department_page=7">Last &gt;&gt;</a></li></ul></div><div class="keys" style="display:none" title="${phpPath }/department/index?Department_page=4"><span>46</span><span>47</span><span>48</span><span>49</span><span>50</span><span>51</span><span>52</span><span>53</span><span>54</span><span>55</span> -->
</div>
&nbsp;