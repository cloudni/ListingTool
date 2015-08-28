package com.lt.backend.system.util;

public class FileTransferException extends Exception
{
	private static final long serialVersionUID = 22217179376427784L;

	public FileTransferException ()
	{
		
	}
	
	public FileTransferException (String msg)
	{
		super(msg);
	}
	
	public FileTransferException (String msg, Throwable cause) {

		super(msg, cause);
	
	}
	
	public FileTransferException(Throwable cause) {

		super(cause);

	}
}
