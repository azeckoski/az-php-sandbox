<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl">
<xsl:output method="html" encoding="utf-8" indent="yes"/>

  <xsl:template match="/">

    <h3>XML DEBUG output - file structure</h3>

    <div style="font-size:small">
      <xsl:apply-templates />
    </div>
  </xsl:template>

  <xsl:template match="*">
    &lt;<xsl:value-of select="name()"/>
    <xsl:for-each select="attribute::*">
      <xsl:text> </xsl:text>
      <xsl:value-of select="name()"/>
      <xsl:text>=&quot;</xsl:text>
      <xsl:value-of select="."/>
      <xsl:text>&quot;</xsl:text>
    </xsl:for-each>
    <xsl:choose>
      <xsl:when test="(string-length(text()) &gt; 0) or (count(./*) &gt; 0)">
        &gt;
        <xsl:if test="string-length(text()) &gt; 0">
          <xsl:value-of select="text()" />
        </xsl:if>
        <xsl:if test="count(./*) &gt; 0">
          <blockquote style="margin-top:2px; margin-left:20px; margin-right:0px; margin-bottom:2px">
            <xsl:apply-templates />
          </blockquote>
        </xsl:if>
        &lt;/<xsl:value-of select="name()"/>&gt;
      </xsl:when>
      <xsl:otherwise>
        <xsl:text> /&gt;</xsl:text>
      </xsl:otherwise>
    </xsl:choose>
    <br/>
  </xsl:template>
</xsl:stylesheet>